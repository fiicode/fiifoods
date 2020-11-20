<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\Vente;
use Illuminate\Http\Request;

class GetItemPriceController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFoodsPrice(Request $request)
    {
        $itemP = Achat::select('priceOfPurchase')
            ->where('foods_name_id', $request['foodsId'])
            ->where('deleted_at', null)
            ->get()->last();
        $itemS = Achat::select('sellingPrice')
            ->where('foods_name_id', $request['foodsId'])
            ->where('sellingPrice', '<>', null)
            ->where('deleted_at', null)
            ->get()->last();
        $pu = 0;
        $pv = 0;
        if ($itemP) {
            $pu = $itemP->priceOfPurchase;
        }
        if ($itemS) {
            $pv = $itemS->sellingPrice;
        }else {
            $vente = Vente::select('pu')
                ->where('foods_name_id', $request['foodsId'])
                ->where('deleted_at', null)
                ->get()->last();
            if ($vente) {
                $pv = $vente->pu;
            }
        }
        return response()->json(['pu' => $pu, 'pv' => $pv], 200);
    }

    public function print(int $id)
    {
        if (!$id) {
            return redirect()->back();
        }
        $v = Vente::select('factureNum')->where('id', $id)->where('deleted_at', null)->get()->first();
        $reste = 0;
        if ($v) {
            $factures = Vente::select('foods_name_id', 'factureNum', 'qtt', 'pu', 'created_at', 'reste')
                ->where([
                    ['deleted_at', null],
                    ['factureNum', $v->factureNum]
                ])->get();
                $reste = $factures->sum('reste');
        }else {
            $factures = Vente::select('foods_name_id', 'factureNum', 'qtt', 'pu', 'created_at', 'reste')
                ->where([
                    ['deleted_at', null],
                    ['id', $id]
                ])->get();
            $reste = $factures->sum('reste');
        }


        return view('service.print', compact('factures', 'reste'));
    }

    public function historique()
    {
        $achats = Achat::where([
            ['deleted_at', null]
        ])->get();
        $ventes = Vente::where([
            ['deleted_at', null]
        ])->get();
        return view('components.historique', compact('achats', 'ventes'));
    }
    public function ventes()
    {
        $ventes = Vente::where([
            ['deleted_at', null]
        ])->get();
        return redirect()->route('ventes.index')->with('ventes', $ventes);
    }
    public function achats()
    {
        $achats = Achat::where([
            ['deleted_at', null]
        ])->get();
        return redirect()->route('achats.index')->with('achats', $achats);
    }
}
