<?php

use App\Model\Client;
use App\Model\Facture;
use App\Model\FoodsName;
use App\Model\Fournisseur;
use App\Model\Option;
use App\Model\Order;
use App\Model\Vente;

/**
 * @param $route
 * @return string
 */
function active($route){
    return \Route::is($route) ? 'active' : '';
}

/**
 * @return int
 */
function get_cmd_num() {
    return Order::count() === 0 ? 1 : Order::count() + 1 ;
}
function get_facture_num() {
    return Facture::count() === 0 ? 1 : Facture::count() + 1 ;
}

/**
 * @param $id
 * @return null
 */
function get_foodsName($id) {
    $foods = FoodsName::where([
       //['deleted_at', null],
       ['id', $id]
    ])->get()->first();
    return $foods ? $foods->foodsName : null;
}

/**
 * @param $foodsName
 * @return null
 */
function get_unite($foodsName) {
    $foods_unite = FoodsName::select('unite_id')
        ->where([
            //['deleted_at', null],
            ['foodsName', $foodsName]
        ])->get()->first();
    $unite = Option::select('name')
        ->where([
            //['deleted_at', null],
            ['unite', true],
            ['id', $foods_unite ? $foods_unite->unite_id : null]
        ])->get()->first();

    return $unite ? $unite->name : null;
}

/**
 * @param $id
 * @return null
 */
function get_founisseur_name($id) {
    $fournisseur = Fournisseur::where([
        //['deleted_at', null],
        ['id', $id]
    ])->get()->first();

    return $fournisseur ? $fournisseur->nom : null;
}

/**
 * @param $id
 * @return null
 */
function get_client_name($id) {
    $client = Client::where([
        //['deleted_at', null],
        ['id', $id]
    ])->get()->first();

    return $client ? $client->nom : null;
}

/**
 * @param $id
 * @return null
 */
function get_founisseur_phone($id) {
    $fournisseur = Fournisseur::where([
        //['deleted_at', null],
        ['id', $id]
    ])->get()->first();

    return $fournisseur ? $fournisseur->phone : null;
}

/**
 * @param $id
 * @return null
 */
function get_client_phone($id) {
    $client = Client::where([
        //['deleted_at', null],
        ['id', $id]
    ])->get()->first();

    return $client ? $client->phone : null;
}

function get_founisseur_solde($id) {
    $achat = \App\Model\Achat::select('reste')
        ->where([
            ['deleted_at', null],
            ['fournisseur_id', $id]
        ])->get()->sum('reste');
    $versement = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['fournisseur_id', '<>', null]
        ])->get()->sum('name');
    return number_format($achat - $versement);
}
function get_client_solde($id) {
    $achat = \App\Model\Vente::select('reste')
        ->where([
            ['deleted_at', null],
            ['client_id', $id]
        ])->get()->sum('reste');
    $versement = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['client_id', '<>', null],
            ['versemClient', true]
        ])->get()->sum('name');
    $credit = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['client_id', '<>', null],
            ['creditClient', true]
        ])->get()->sum('name');
    return number_format(($achat + $credit) - $versement);
}
function get_sale_today() {
    $ventes = Vente::select('mtt')
    ->where([
        ['deleted_at', null],
        ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
    ])->get()->sum('mtt');
    return number_format($ventes);
}
function get_credit_today() {
    $ventes = Vente::select('reste')
        ->where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('reste');
    return number_format($ventes);
}
function get_commande_today() {
    $commandes = \App\Model\Achat::select('mntTotalAchat')
        ->where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('mntTotalAchat');
    return number_format($commandes);
}
function get_prix_achat($id) {
    $priceOfPurchase = \App\Model\Achat::select('priceOfPurchase')
        ->where([
            ['deleted_at', null],
            ['foods_name_id', $id]
        ])->get()->last();
    return $priceOfPurchase ? number_format($priceOfPurchase->priceOfPurchase) : null;
}
function get_total_foods($id) {
    $qtt = \App\Model\Achat::select('qtt')
        ->where([
            ['deleted_at', null],
            ['foods_name_id', $id]
        ])->get()->sum('qtt');
    return $qtt;
}