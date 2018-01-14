<?php

namespace App\Http\Controllers;

use App\Helpers\ImportCSV;
use App\Http\Requests\UploadProspectCSVRequest;
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
        return view('prospects.upload');
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
     */
    public function csvBuilder(Request $request)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $fileName = storage_path('app/public/csvimport/'.$request->fileName);

        $results = \Excel::load($fileName, function($reader) {
        })->get();

        foreach ($results as $item)
        {
            dd($item);
        }
    }
}
