<?php

use App\Model\Achat;
use App\Model\Client;
use App\Model\Depense;
use App\Model\Facture;
use App\Model\FoodsName;
use App\Model\Fournisseur;
use App\Model\Option;
use App\Model\Order;
use App\Model\Vente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @param $route
 * @return string
 */
function active($route)
{
    return Route::is($route) ? 'active' : '';
}

function isAuth() {
    // dump(Session::get('userdeleted'));
    return Auth::user()->deleted_at == null ? null : isLogout();
}

function isLogout() {
    Auth::logout();
    Session::put('userdeleted', 'userdeleted');
    return redirect()->back()->with('userdeleted', 'userdeleted');
}

function getLogout() 
{
    Session::flush();
    // $this->auth->logout();
    // return redirect(property_exists($this, 'redirectAfterLogout') ?? $this->redirectAfterLogout );

}

/**
 * @return int
 */
function get_cmd_num()
{
    return Order::count() === 0 ? 1 : Order::count() + 1;
}

function get_facture_num()
{
    return Facture::count() === 0 ? 1 : Facture::count() + 1;
}

/**
 * @param $id
 * @return null
 */
function get_foodsName($id)
{
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
function get_unite($foodsName)
{
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
function get_founisseur_name($id)
{
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
function get_client_name($id)
{
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
function get_founisseur_phone($id)
{
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
function get_client_phone($id)
{
    $client = Client::where([
        //['deleted_at', null],
        ['id', $id]
    ])->get()->first();

    return $client ? $client->phone : null;
}

function get_founisseur_solde($id)
{
    $achat = Achat::select('reste')
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
function get_client_solde($id)
{
    $achat = Vente::select('reste')
        ->where([
            ['deleted_at', null],
            ['client_id', $id]
        ])->get()->sum('reste');
    $versement = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['client_id', '<>', null],
            ['versemClient', true],
            ['client_id', $id]
        ])->get()->sum('name');
    $credit = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['client_id', '<>', null],
            ['creditClient', true],
            ['client_id', $id]
        ])->get()->sum('name');
    return number_format(($achat + $credit) - $versement);
}

/**
 * @return string
 */
function get_sale_today()
{
    $ventes = Vente::select('mtt')
        ->where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('mtt');
    return number_format($ventes);
}

/**
 * @return string
 */
function get_credit_today()
{
    $credit_facture = Vente::select('reste')
        ->where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('reste');
    $versement = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['versemClient', true],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('name');
    $credit = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['creditClient', true],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('name');
    return number_format(($credit_facture + $credit) - $versement);
}

/**
 * @return string
 */
function get_commande_today()
{
    $commandes = Achat::select('mntTotalAchat')
        ->where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get()->sum('mntTotalAchat');
    return number_format($commandes);
}
function get_int_today()
{
    $foodsNames = FoodsName::select('id')
        ->where([
            ['deleted_at', null],
            ['inventaire', true]
        ])->get();
    $montant = 0;
    foreach ($foodsNames as $value) {
        $ventes = Vente::select('foods_name_id', 'qtt', 'pu', 'created_at')
            ->where([
                ['deleted_at', null],
                ['created_at', '>=', Date('Y-m-d') . ' 00:00:00'],
                ['foods_name_id', $value->id]
            ])->get();
        if ($ventes) {
            foreach ($ventes as $vente) {
                $priceOfPurchase = Achat::select('priceOfPurchase')
                    ->where([
                        ['deleted_at', null],
                        ['foods_name_id', $vente->foods_name_id],
                        ['created_at', '<=', $vente->created_at]
                    ])->get()->last();
                if ($vente->pu < $priceOfPurchase->priceOfPurchase) {
                    return 'ERREUR DE DONNEE';
                } else {
                    $montant += $vente->qtt * ($vente->pu - $priceOfPurchase->priceOfPurchase);
                }
            }
        }
    }
    return number_format($montant);
}

/**
 * @param $id
 * @return null|string
 */
function get_prix_achat($id)
{
    $priceOfPurchase = Achat::select('priceOfPurchase')
        ->where([
            ['deleted_at', null],
            ['foods_name_id', $id]
        ])->get()->last();
    return $priceOfPurchase ? number_format($priceOfPurchase->priceOfPurchase) : null;
}

/**
 * @param $id
 * @return mixed
 */
function get_total_foods($id)
{
    $qtt = Achat::select('qtt')
        ->where([
            ['deleted_at', null],
            ['foods_name_id', $id]
        ])->get()->sum('qtt');
    return $qtt;
}

/**
 * Pipeline
 */

function get_commande_all()
{
    $commandes = Achat::select('mntTotalAchat')
        ->where([
            ['deleted_at', null]
        ])->get()->sum('mntTotalAchat');
    return number_format($commandes);
}
function get_stock_all()
{
    $foodsNames = FoodsName::select('id')
        ->where([
            ['deleted_at', null],
            ['inventaire', true]
        ])->get();
    $commandes = [];
    $factures = [];
    foreach ($foodsNames as $value) {
        $vente = Vente::select('qtt')
            ->where([
                ['deleted_at', null],
                ['foods_name_id', $value->id]
            ])->get()->sum('qtt');
        $achat = Achat::select('qtt')
            ->where([
                ['deleted_at', null],
                ['foods_name_id', $value->id]
            ])->get()->sum('qtt');
        $factures[$value->id] = $vente;
        $commandes[$value->id] = $achat;
    }
    $stocks = [];
    foreach ($commandes as $commande => $key) {
        foreach ($factures as $facture => $k) {
            if ($commande === $facture) {
                $stocks[$commande] = bcsub($key, $k);
            }
        }
    }
    $mtt = 0;
    foreach ($stocks as $stock => $value) {
        $pa = Achat::select('priceOfPurchase')
            ->where([
                ['deleted_at', null],
                ['foods_name_id', $stock]
            ])->get()->last();
        $mtt += $value * $pa->priceOfPurchase;
    }
    return number_format($mtt);
}
function get_sale_all()
{
    $ventes = Vente::select('mtt')
        ->where([
            ['deleted_at', null]
        ])->get()->sum('mtt');
    return number_format($ventes);
}
function get_int_all()
{
    $foodsNames = FoodsName::select('id')
        ->where([
            ['deleted_at', null],
            ['inventaire', true]
        ])->get();
    $montant = 0;
    foreach ($foodsNames as $value) {
        $ventes = Vente::select('foods_name_id', 'qtt', 'pu', 'created_at')
            ->where([
                ['deleted_at', null],
                ['foods_name_id', $value->id]
            ])->get();
        if ($ventes) {
            foreach ($ventes as $vente) {
                $priceOfPurchase = Achat::select('priceOfPurchase')
                    ->where([
                        ['deleted_at', null],
                        ['foods_name_id', $vente->foods_name_id],
                        ['created_at', '<=', $vente->created_at]
                    ])->get()->last();

                if ($priceOfPurchase) {
                    if ($vente->pu < $priceOfPurchase->priceOfPurchase) {
                        return 'ERREUR DE DONNEE';
                    } else {
                        $montant += $vente->qtt * ($vente->pu - $priceOfPurchase->priceOfPurchase);
                    }
                }
            }
        }
    }
    return number_format($montant);
}
function get_credit_all()
{
    $credit_facture = Vente::select('reste')
        ->where([
            ['deleted_at', null]
        ])->get()->sum('reste');
    $versement = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['versemClient', true]
        ])->get()->sum('name');
    $credit = Option::select('name')
        ->where([
            ['deleted_at', null],
            ['creditClient', true]
        ])->get()->sum('name');
    return number_format(($credit_facture + $credit) - $versement);
}


function get_motif()
{
    return Option::where([
        ['deleted_at', null],
        ['motif', true]
    ])->get();
}

function get_entite()
{
    return Option::where([
        ['deleted_at', null],
        ['entite', true]
    ])->get();
}

function get_option_name($id)
{
    $name = Option::where('id', $id)->get()->first();

    return $name ? $name->name : null;
}


function access_order()
{
    return check_authorize_menu("commande");
}

function access_sell()
{
    return check_authorize_menu("vente");
}

function access_anal()
{
    return check_authorize_menu("bilan");
}

function check_authorize_menu($menuName)
{
    // verification de l'existance de role_id dans l'option
    if(!Auth::user()) {
        return redirect()->back();
    }
    $roleId = Option::where([
        ['id', Auth::user()->role_id],
        ['role', true]
    ])->get()->first();

    // verification du role - menu (fields)
    if ($roleId) {
        $menus = DB::table('menu_role')->where('role_id', $roleId->id)->get();
        $r = false;
        foreach ($menus as $menu) {
            // dump(check_menu_name($menu->menu_id) === $menuName);
            if (check_menu_name($menu->menu_id) === $menuName) {
                $r = true;
            }
        }
        return $r;
    }
}

function check_menu_name($id)
{
    return (
        (Option::where([
            ['id', $id],
            ['menu', true],
            ['deleted_at', null]
        ])->get("name")->first())->name
    );
}

function getUserDepense()
{
    $data = Depense::where([
        ['deleted_at', null],
    ])->get('user_id');

    // dd($data);
    
    return $data;
}