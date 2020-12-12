<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\FoodsName;
use App\Model\Vente;
use Illuminate\Http\Request;

class PipelineController extends Controller
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

        $ventes = Vente::where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get();
        $unique = $ventes->unique('foods_name_id');
        $foodsName = [];
        foreach ($unique as $foods) {
            $foodsName[get_foodsName($foods->foods_name_id)][$ventes->where('foods_name_id', $foods->foods_name_id)->sum('qtt')] = $ventes->where('foods_name_id', $foods->foods_name_id)->sum('mtt');
        }
        $ventes = collect($foodsName);
        return view('components.pipeline', compact('ventes', 'stocks'));
    }

    public function recherche(Request $request)
    {
        $date1 = explode('-', $request['du']);
        $date2 = explode('-', $request['au']);
        $du = $date1[0] . '-' . $date1[1] . '-' . $date1[2] . ' 00:00:00';
        $au = $date2[0] . '-' . $date2[1] . '-' . $date2[2] . ' 23:59:59';

        return redirect()->route('pipeline')
            ->with('vente', $this->get_vente($du, $au))
            ->with('interet', $this->get_interet($du, $au))
            ->with('du', $date1[2] . '-' . $date1[1] . '-' . $date1[0])
            ->with('au', $date1[2] . '-' . $date1[1] . '-' . $date1[0]);
    }

    private function get_vente($du, $au)
    {
        $ventes = Vente::select('mtt')
            ->where([
                ['created_at', '>=', $du . ' 00:00:00'],
                ['created_at', '<=', $au . ' 23:59:59'],
                ['deleted_at', null],
            ])->get()->sum('mtt');
        return number_format($ventes);
    }
    private function get_interet($du, $au)
    {
        $foodsNames = FoodsName::select('id')
            ->where([
                ['deleted_at', null],
                ['inventaire', true]
            ])->get();
        $montant = 0;
        foreach ($foodsNames as $value) {
            $ventes = Vente::select('qtt', 'pu', 'created_at')
                ->where([
                    ['deleted_at', null],
                    ['created_at', '>=', $du . ' 00:00:00'],
                    ['created_at', '<=', $au . ' 23:59:59'],
                    ['foods_name_id', $value->id]
                ])->get();
            foreach ($ventes as $vente) {
                $priceOfPurchase = Achat::select('priceOfPurchase')
                    ->where([
                        ['deleted_at', null],
                        ['created_at', '<=', $vente->created_at]
                    ])->get()->last();
                if ($vente->pu < $priceOfPurchase->priceOfPurchase) {
                    return 'ERREUR DE DONNEE';
                } else {
                    $montant += $vente->qtt * ($vente->pu - $priceOfPurchase->priceOfPurchase);
                }
            }
        }
        return number_format($montant);
    }
}
