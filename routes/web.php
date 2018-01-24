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
    Route::resource('prospect', 'ProspectController');
    Route::post('/prospect/add-credit/{prospectId}', 'ProspectController@ajaxAddCredit');
    Route::post('/prospect/credit/{prospectId}', 'ProspectController@ajaxUpdateCredit');
    Route::delete('/prospect/delete-credit/{prospectId}', 'ProspectController@ajaxDeleteCredit');

    /**
     * IMPORT DE PROSPECT
     */
    Route::get('import', 'UploadProspect@index')->name('prospect.import');
    Route::post('import/upload', 'UploadProspect@uploadFile')->name('prospect.upload');
    Route::delete('remove/file', 'UploadProspect@deleteFile')->name('remove.file');
    Route::post('import/csv/builder', 'UploadProspect@csvBuilder')->name('prospect.csv.import');

    Route::post('save/temp/prospect/{id}', 'UploadProspect@save')->name('save.temp.prospect');
    Route::delete('delete/temp/prospect/{id}', 'UploadProspect@delete')->name('delete.temp.prospect');

    Route::get('/create/imported/prospect/{prospectId}', 'UploadProspect@createImportedProspect' )->name('create.imported.prospect');

    /**
     * GESTION DES BANQUES
     */
    Route::resource('banques', 'BanquesController');

    /**
     * GESTION DES DOSSIERS
     */
    Route::resource('dossiers', 'DossierController');
    Route::get('dossier/prospect/autocomplete/name', 'DossierController@autoCompleteNom');
});

