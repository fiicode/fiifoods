<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\Client;
use App\Model\Depense;
use App\Model\Facture;
use App\Model\FoodsName;
use App\Model\Fournisseur;
use App\Model\Membre;
use App\Model\Option;
use App\Model\Order;
use App\Model\Vente;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;

class GetUniqueSearch extends Controller
{
    public function showfoods(Request $request)
    {
        $foods_name = FoodsName::find($request->foods_name);
        // dd($foods_name);
        return view('components.showfoods', compact('foods_name'));
    }

    public function showachat(Request $request)
    {
        $achat = Achat::find($request->achat);
        return view('components.showachat')->with('achat', $achat);
    }

    public function showclient(Request $request)
    {
        $client = Client::find($request->client);
        return view('components.showclient', compact('client'));
    }

    public function showfournisseur(Request $request)
    {
        $fournisseur = Fournisseur::find($request->fournisseur);
        return view('components.showfournisseur', compact('fournisseur'));
    }

    public function showvente(Request $request)
    {
        $vente = Vente::find($request->vente);
        return view('components.showvente', compact('vente'));
    }

    public function showdepense(Request $request)
    {
        $depense = Depense::find($request->depense);
        return view('components.showdepense', compact('depense'));
    }

    public function showfacture(Request $request)
    {
        $facture = Facture::find($request->facture);
        return view('components.showfacture', compact('facture'));
    }

    public function showmembre(Request $request)
    {
        $membre = Membre::find($request->membre);
        return view('components.showmembre', compact('membre'));
    }

    public function showoption(Request $request)
    {
        $option = Option::find($request->option);
        return view('components.showoption', compact('option'));
    }

    public function showorder(Request $request)
    {
        $order = Order::find($request->order);
        return view('components.showorder', compact('order'));
    }
}
