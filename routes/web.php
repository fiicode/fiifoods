<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
//    return view('welcome');
    return view('auth.login');
});


Auth::routes();
Route::group(['middleware' => ['auth']], function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/recherche', 'SearchController@store')->name('rechercheData');
    Route::get('/activiste', 'ActivisteController@index')->name('activiste');
    Route::get('/pipeline', 'PipelineController@index')->name('pipeline');
    Route::get('/sample', 'HomeController@sample')->name('sample');
    Route::post('/pipeline', 'PipelineController@recherche')->name('recherche');
    Route::resource('achats', 'AchatController');
    Route::resource('ventes', 'VenteController');
    Route::resource('users', 'UserController');
    Route::resource('option', 'OptionController');
    Route::resource('membre', 'MembreController');
    Route::resource('fournisseur', 'FournisseurController');
    Route::resource('client', 'ClientController');
    Route::resource('membre', 'MembreController');
    Route::resource('foodsName', 'FoodsNameController');
    Route::resource('depense', 'DepenseController');
    Route::patch('fournisseurPhone/{id}', 'GetFournisseurPhoneController@phone')->name('fournisseurPhone.phone');
    Route::patch('clientPhone/{id}', 'GetClientPhoneController@phone')->name('clientPhone.phone');
    Route::get('versement_ou_credit_client/{id}', 'VersementClientController@show')->name('vesementClient.show');
    Route::get('versement_fournisseur/{id}', 'VersementFournisseurController@show')->name('vesementFournisseur.show');
    Route::post('versementClient', 'VersementClientController@versement')->name('vesementClient.versemnt');
    Route::post('versementFournisseur', 'VersementFournisseurController@versement')->name('vesementFournisseur.versemnt');
    Route::post('creditClient', 'CreditClientController@credit')->name('creditClient.credit');
    Route::post('motif', 'CreditClientController@motif')->name('motif');
    Route::post('entite', 'CreditClientController@entite')->name('entite');
    Route::get('/prixFoods/{foods}', [
        'uses' => 'GetItemPriceController@getFoodsPrice',
        'as' => 'price',
        'middleware' => 'auth'
    ]);
    Route::get('/print/{id}', [
        'uses' => 'GetItemPriceController@print',
        'as' => 'print',
        'middleware' => 'auth'
    ]);
    Route::get('Historique', [
        'uses' => 'GetItemPriceController@historique',
        'as' => 'historique',
        'middleware' => 'auth'
    ]);
    Route::get('Ventes', [
        'uses' => 'GetItemPriceController@ventes',
        'as' => 'ventes',
        'middleware' => 'auth'
    ]);
    Route::get('Achats', [
        'uses' => 'GetItemPriceController@achats',
        'as' => 'achats',
        'middleware' => 'auth'
    ]);
});


