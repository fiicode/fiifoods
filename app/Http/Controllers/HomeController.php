<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\FoodsName;
use App\Model\Vente;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foodsNames = FoodsName::select('id')
        ->where([
            ['deleted_at', null],
            ['inventaire', true]
        ])->get();
        $commandes = [];
        $factures = [];
        foreach($foodsNames as $value) {
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
        foreach ($commandes as $commande=>$key) {
            foreach ($factures as $facture=>$k) {
                if($commande === $facture) {
                    $stocks[$commande] = bcsub($key, $k);
                }
            }
        }

        $ventes = Vente::where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get();
        $unique = $ventes->unique('foods_name_id');
        $foodsName = [];
        foreach ($unique as $foods){
            $foodsName[get_foodsName($foods->foods_name_id)][$ventes->where('foods_name_id', $foods->foods_name_id)->sum('qtt')] = $ventes->where('foods_name_id', $foods->foods_name_id)->sum('mtt');
        }
        $ventes = collect($foodsName);
        return view('home', compact('ventes', 'stocks'));
    }

    public function sample() {
        $commande = Achat::select('mntTotalAchat')->sum('mntTotalAchat');
        $vente = Vente::select('mtt')->sum('mtt');
        return view('components.sample', compact('commande', 'vente'));
    }
}
