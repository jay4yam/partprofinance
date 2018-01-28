<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', 'HomeController@index')->name('home');

    /**
     * RESOURCE MODEL PROSPECT
     */
    //Route resource contenant index, show, edit, save... pour le model Prospect
    Route::resource('prospect', 'ProspectController');
    //requête ajax qui gère l'ajout d'un credit
    Route::post('/prospect/add-credit/{prospectId}', 'ProspectController@ajaxAddCredit');
    //Requête ajax qui gère la mise à jour d'un credit
    Route::post('/prospect/credit/{prospectId}', 'ProspectController@ajaxUpdateCredit');
    //Requête ajax qui gère la suppression d'un credit
    Route::delete('/prospect/delete-credit/{prospectId}', 'ProspectController@ajaxDeleteCredit');

    /**
     * IMPORT DE PROSPECT
     */
    //Affiche la vue prospect.index avec la liste des prospectTemps
    Route::get('import', 'UploadProspect@index')->name('prospect.import');
    //Gère l'upload de fichier .csv
    Route::post('import/upload', 'UploadProspect@uploadFile')->name('prospect.upload');
    //Suprrime l'un des fichiers .csv
    Route::delete('remove/file', 'UploadProspect@deleteFile')->name('remove.file');

    //Gère le clic sur le bouton importer dans la vue Prospect.index
    Route::post('import/csv/builder', 'UploadProspect@csvBuilder')->name('prospect.csv.import');

    //Gère la sauv. d'un prospect
    Route::post('save/temp/prospect/{id}', 'UploadProspect@save')->name('save.temp.prospect');
    //supprime un prospect temp de la table
    Route::delete('delete/temp/prospect/{id}', 'UploadProspect@delete')->name('delete.temp.prospect');

    //Affiche la vue creation de prospect depuis l'import d'un fichier
    Route::get('create/imported/prospect/{prospectId}', 'UploadProspect@createImportedProspect' )->name('create.imported.prospect');


    /**
     * GESTION DE PROCESS COMMERCIAUX LIES AUX PROSPECTS
     * Gère les différents process liés au traitement d'un prospect
     */
    //Gère la réponse de la dropdownlist 'status' sur la vue Prospect.index
    Route::post('process/update/status', 'ProspectProcessController@updateStatus')->name('process.update.status');

    //Affiche la vue Prospect.relance avec le contenu des messages MAIL & SMS
    Route::get('process/prospect/relance/{id}', 'ProspectProcessController@relanceUne')->name('process.relanceUne');

    //Gère la soumission de la relance 1 & 2
    Route::post('process/propect/send/relance', 'ProspectProcessController@sendRelanceUne')->name('process.send.relance.une');

    /**
     * GESTION DES BANQUES
     */
    Route::resource('banques', 'BanquesController');

    /**
     * GESTION DES DOSSIERS
     */
    Route::resource('dossiers', 'DossierController');
    Route::get('dossier/prospect/autocomplete/name', 'DossierController@autoCompleteNom');


    /**
     * GESTION DU CALENDRIER
     */

    //Récupère la liste des relance JP+1 et JP4 du processProspect
    Route::get('/process/prospect/get/relance', 'CalendarController@getMonthRelance')->name('get.relance');

    //Récupère la liste des relance JP+1 et JP4 du processProspect
    Route::get('/dossier/prospect/create', 'CalendarController@getMonthDossier')->name('get.dossier');
});

