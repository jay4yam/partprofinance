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
     * IMPORT DE PROSPECT & PROSPECT TEMPORAIRE
     */
    //1. Affiche la vue prospect.index avec la liste des prospectTemps
    Route::get('import', 'UploadProspect@index')->name('prospect.import');
    //2. Gère l'upload de fichier .csv
    Route::post('import/upload', 'UploadProspect@uploadFile')->name('prospect.upload');
    //3. Suprrime l'un des fichiers .csv
    Route::delete('remove/file', 'UploadProspect@deleteFile')->name('remove.file');
    //4. Gère le clic sur le bouton importer dans la vue Prospect.index
    Route::post('import/csv/builder', 'UploadProspect@csvBuilder')->name('prospect.csv.import');
    //5. Gère la sauv. d'un prospect
    Route::post('save/temp/prospect/{id}', 'UploadProspect@save')->name('save.temp.prospect');
    //6. supprime un prospect temp de la table
    Route::delete('delete/temp/prospect/{id}', 'UploadProspect@delete')->name('delete.temp.prospect');
    //7. Affiche la vue creation de prospect depuis l'import d'un fichier
    Route::get('create/imported/prospect/{prospectId}', 'UploadProspect@createImportedProspect' )->name('create.imported.prospect');

    Route::resource('/temp_prospect', 'TempProspectController');
    /**
     * GESTION DE PROCESS COMMERCIAUX LIES AUX PROSPECTS
     * Gère les différents process liés au traitement d'un prospect
     */
    //Gère la réponse de la dropdownlist 'status' sur la vue Prospect.index
    Route::post('process/update/status', 'ProspectProcessController@updateStatus')->name('process.update.status');

    //Gère la route pour la modification de l'item relance_status
    Route::put('process/update/{id}', 'ProspectProcessController@update')->name('process.update');

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
    Route::get('dossier/sendmail/{dossier}', 'DossierController@sendMailShow')->name('send.mail.dossier');
    Route::post('dossier/postmail/', 'DossierController@postMail')->name('post.mail');

    //requete ajax pour obtenir les infos d'un dossier
    Route::post('/get/dossier/info', 'DossierController@getDossier');


    /**
     * GESTION DU CALENDRIER
     */
    //Récupère la liste des relance JP+1 et JP4 du processProspect
    Route::get('/get/prospect/relance', 'CalendarController@getMonthRelance')->name('get.relance');

    //Récupère la liste des dossiers du mois
    Route::get('/get/month/dossier', 'CalendarController@getMonthDossier')->name('get.dossier');

    //Récupère la liste des tasks du mois
    Route::get('/get/task/calendar', 'CalendarController@getMonthTask')->name('get.task');

    /**
     * GESTION DES TASKS
     */
    //Route resource contenant index, show, edit, save... pour le model Task
    Route::resource('task', 'TaskController');

    /** GESTION DES UTILISATEURS **/
    Route::resource('user', 'UserController');

    /* EDITION & GENERATION DE MANDAT */
    Route::get('mandat/edition', 'MandatController@editMandat')->name('mandat.edition');
    Route::get('mandat/generate', 'MandatController@generateMandat')->name('mandat.generate');

});

