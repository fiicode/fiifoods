<?php

namespace App\Http\Controllers;

use App\Model\Client;
use App\Model\FoodsName;
use App\Model\Fournisseur;
use App\Model\Option;
use App\Model\Vente;
use Illuminate\Http\Request;

class ActivisteController extends Controller
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
        $fournisseurs = Fournisseur::where([
            ['deleted_at', null]
        ])->get();
        $clients = Client::where([
            ['deleted_at', null]
        ])->get();
        $mouvements = Option::where([
            ['deleted_at', null],
            ['client_id', '<>', null]
        ])->OrWhere('fournisseur_id', '<>', null)->get();

        return view('components.activiste', compact( 'fournisseurs', 'clients', 'mouvements'));
    }
}
