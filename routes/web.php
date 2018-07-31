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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/activiste', 'ActivisteController@index')->name('activiste');
    Route::resource('achats', 'AchatController');
    Route::resource('ventes', 'VenteController');
    Route::resource('option', 'OptionController');
    Route::resource('membre', 'MembreController');
    Route::resource('fournisseur', 'FournisseurController');
    Route::resource('client', 'ClientController');
    Route::resource('membre', 'MembreController');
    Route::resource('foodsName', 'FoodsNameController');
    Route::patch('fournisseurPhone/{id}', 'GetFournisseurPhoneController@phone')->name('fournisseurPhone.phone');
    Route::patch('clientPhone/{id}', 'GetClientPhoneController@phone')->name('clientPhone.phone');
    Route::get('versement_ou_credit_client/{id}', 'VersementClientController@show')->name('vesementClient.show');
    Route::get('versement_fournisseur/{id}', 'VersementFournisseurController@show')->name('vesementFournisseur.show');
    Route::post('versementClient', 'VersementClientController@versement')->name('vesementClient.versemnt');
    Route::post('versementFournisseur', 'VersementFournisseurController@versement')->name('vesementFournisseur.versemnt');
    Route::post('creditClient', 'CreditClientController@credit')->name('creditClient.credit');
});


