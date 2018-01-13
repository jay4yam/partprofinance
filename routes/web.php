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
    Route::resource('prospect', 'ProspectController');
    Route::post('/prospect/add-credit/{prospectId}', 'ProspectController@ajaxAddCredit');
    Route::delete('/prospect/delete-credit/{prospectId}', 'ProspectController@ajaxDeleteCredit');
});

