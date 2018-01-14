<?php

namespace App\Http\Controllers;

use App\Helpers\AssureAgencyData;
use App\Helpers\DevisProxData;
use App\Helpers\ImportCSV;
use App\Http\Requests\UploadProspectCSVRequest;
use App\Models\TempProspect;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class UploadProspect extends Controller
{

    /**
     * Renvois la vue "index" d'upload de fichier .csv
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Récupère la liste des prospects de la table tempProspects
        $prospectsTemp = TempProspect::all(['id', 'prospect_source', 'nom', 'email']);

        return view('prospects.upload', compact('prospectsTemp'));
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
                return back()->withException($exception);
            }

            return back();
        }
        return back();
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
        //Récupère le nom du fichier importer par l'utilisateur
        $fileName = storage_path('app/public/csvimport/'.$request->fileName);

        //Instancie un import "Excel"
        $import = new ImportCSV($app, $excel, $fileName);

        //Récupère le contenu du fichier
        $results = $import->get();

        //Récupère la source du fichier ('assureagency' ou 'devisprox')
        $prospectSource = $this->dataType($request->fileName);

        //Enregistre en session dans un tableau de prospects
        $import->storeInTemp($results, $prospectSource);

        return back();
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
