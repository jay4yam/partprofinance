<?php

namespace App\Http\Controllers;

use App\Helpers\AssureAgencyData;
use App\Helpers\DevisProxData;
use App\Helpers\ImportCSV;
use App\Http\Requests\UploadProspectCSVRequest;
use App\Models\TempProspect;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Mockery\Exception;

class UploadProspect extends Controller
{

    /**
     * Renvois la vue "index" d'upload de fichier .csv
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Récupère la liste des prospects de la table tempProspects
        $prospectsTemp = TempProspect::with('processProspect')->orderBy('id', 'desc')->paginate('10');

        return view('prospects.upload', compact('prospectsTemp'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, $id)
    {
        //1. récupère le prospect temporaire
        $prospect = TempProspect::findOrFail($id);

        //3. redirige vers la page de création 'prospect' liée à la table l'utilisateur
        return redirect()->route('create.imported.prospect', [ 'prospectId' => $prospect->id ]);
    }

    /**
     * Affiche la vue de création de prospect liée à la table user
     * @param $userId
     * @param $prospectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createImportedProspect($prospectId)
    {
        //Récupère les infos stockées dans la table tempProspect
        $tempProspect = TempProspect::findOrFail($prospectId);

        //Retourne la vue en lui passant en paramètre le user et le tempProspect
        return view('prospects.createImported', compact('user', 'tempProspect'));
    }

    /**
     * Suppression d'une ligne de la table tempprospect
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        try {

            //1. recupere l'enregistrement à effacer
            $temp = TempProspect::with('processProspect')->findOrFail($id);

            //2. Efface l'enregistrement
            $temp->processProspect()->delete();
            $temp->delete();

        }catch (\Exception $exception){
            //renvois un mesage si erreur
            return back()->with(['message' => $exception->getMessage()]);
        }
        // renvois un message si succès
        return back()->with(['message' => 'suppression du prospect OK']);
    }

    /**
     * Gère l'enregistrement du fichier csv uploader par l'utilisateur
     * @param UploadProspectCSVRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function uploadFile(UploadProspectCSVRequest $request)
    {
        //1. Enregistrer le fichier
        if($request->file('csvfile')->isValid()){
            $file = $request->file('csvfile');
            $name = $request->fournisseur.'-'.time();
            try {
                $file->storeAs('public/csvimport', $name.'.csv');
            }catch (\Exception $exception){
                return back()->with(['message' => $exception]);
            }
        }
        return back()->with(['message' => 'upload du fichier csv OK']);
    }

    /**
     * Supprime l'un des fichiers csv
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile(Request $request)
    {
        try {

            //1. récupère le nom du fichier
            $fileName = $request->fileName;
            //2. Supprime le ficher du dossier
            Storage::delete('/public/csvimport/' . $fileName);

        }catch (\Exception $exception){
            //Renvois un message d'erreur
            return back()->with(['message' => $exception->getMessage()]);
        }
        //redirect avec message
        return back()->with(['message' => 'Supression du fichier csv OK']);
    }

    /**
     * Gère le traitement du fichier .csv
     * @param Request $request
     * @param Application $app
     * @param Excel $excel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function csvBuilder(Request $request, Application $app, Excel $excel)
    {
        try {
            //Récupère le nom du fichier importer par l'utilisateur
            $fileName = storage_path('app/public/csvimport/' . $request->fileName);

            //Instancie un import "Excel"
            $import = new ImportCSV($app, $excel, $fileName);

            //Récupère le contenu du fichier
            $results = $import->get();

            //Récupère la source du fichier ('assureagency' ou 'devisprox')
            $prospectSource = $this->dataType($request->fileName);

            //Enregistre en session dans un tableau de prospects
            $import->storeInTemp($results, $prospectSource);
        }catch (\Exception $exception){
            return back()->with(['message' => $exception->getMessage()]);
        }

        return back()->with(['message' => 'Traitement fichier OK']);
    }

    /**
     * Retourne la classe de donnée correspondant au nom du fichier que l'utilisateur veut traiter
     * @param $fileName
     * @return string
     */
    private function dataType($fileName)
    {
        $array = explode('-', $fileName);

        switch ($array[0]){
            case 'assuragency':
                return 'assuragency';
                break;
            case 'devisprox':
                return 'devisprox';
                break;
        }

    }
}
