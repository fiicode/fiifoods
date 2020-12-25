<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\Client;
use App\Model\Facture;
use App\Model\FoodsName;
use App\Model\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = FoodsName::where([
                ['deleted_at', null],
                //['inventaire', true]
            ])->orderBy('foodsName', 'asc')->get();
        $ventes = Vente::where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00']
        ])->get();
        $clients = Client::select('nom')->where('deleted_at', null)->get();

        $tab = [];
        foreach ($clients as $client) {
            $tab[] = $client->nom;
        }
        $clients = collect($tab)->toJson();
        return view('components.vente', compact( 'produits', 'ventes', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom'       => 'nullable|min:2',
            'phone'     => 'nullable|min:2',
            'foodsName' => 'required|integer|min:1',
            'qtt'       => 'required|integer|min:1',
            'paye'      => 'nullable|numeric|min:0',
            'prixAchat' => 'required|numeric|min:0',
            'factureNum'   => 'nullable|min:2'
        ]);
        $client = null;
        $factureNum = null;
        if ($request['nom']) {
            $client = Client::where([
                ['nom', $request['nom']],
                ['phone', $request['phone']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$client) {
                Client::firstOrcreate([
                    'nom' => $request['nom'],
                    'phone' => isset($request['phone']) ? $request['phone'] : null,
                    'user_id' => Auth::user()->id
                ]);
                $client = Client::where([
                    ['nom', $request['nom']],
                    ['phone', $request['phone']]
                ])->get()->first();
            }
        }
        if ($request['factureNum']) {
            $factureNum = Facture::where([
                ['factureNum', $request['factureNum']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$factureNum) {
                Facture::create([
                    'factureNum' => $request['factureNum'],
                    'user_id' => Auth::user()->id
                ]);
                $factureNum = Facture::where([
                    ['factureNum', $request['factureNum']],
                    ['deleted_at', null]
                ])->get()->first();
            }
        }
        $type = 'error-facture';
        $message = "facture existe déjà.";

        $foods_name_id = FoodsName::select('id', 'unite_id')
            ->where([
                ['deleted_at', null],
                ['id', $request['foodsName']]
            ])->get()->first();
        if ($foods_name_id) {
            Vente::create([
                'foods_name_id' => $foods_name_id->id,
                'factureNum' => $factureNum ? $factureNum->factureNum : null,
                'qtt' => $request['qtt'],
                'pu' => $request['prixAchat'],
                'paye' => $request['paye'] >=0 && $request['paye'] <= $request['qtt'] * $request['prixAchat'] ? $request['paye'] : $request['qtt'] * $request['prixAchat'],
                'client_id' => $client ? $client->id : null,
                'facture_id' => $factureNum ? $factureNum->id : null,
                'user_id' => Auth::user()->id
            ]);
            $type = 'success-facture';
            $message = "commande existe déjà.";
        }
        return redirect()->route('ventes.index')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function show(Vente $vente)
    {
        return redirect()->route('ventes.index')->with('vente', $vente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function edit(Vente $vente)
    {
        $vente->deleted_at = Date('Y-m-d H:i:s');
        $vente->update();
        return redirect()->route('ventes.index')->with('supression-facture', 'facture supprimé');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vente $vente)
    {
        $client = null;
        $factureNum = null;
        if ($request['nom']) {
            $client = Client::where([
                ['nom', $request['nom']],
                ['phone', $request['phone']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$client) {
                Client::firstOrcreate([
                    'nom' => $request['nom'],
                    'phone' => isset($request['phone']) ? $request['phone'] : null,
                    'user_id' => Auth::user()->id
                ]);
                $client = Client::where([
                    ['nom', $request['nom']],
                    ['phone', $request['phone']]
                ])->get()->first();
            }
        }
        if ($request['factureNum']) {
            $factureNum = Facture::where([
                ['factureNum', $request['factureNum']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$factureNum) {
                Facture::create([
                    'factureNum' => $request['factureNum'],
                    'user_id' => Auth::user()->id
                ]);
                $factureNum = Facture::where([
                    ['factureNum', $request['factureNum']],
                    ['deleted_at', null]
                ])->get()->first();
            }
        }
        $type = null;
        $message = null;

        $foods_name_id = FoodsName::select('id', 'unite_id')
            ->where([
                ['deleted_at', null],
                ['id', $request['foodsName']]
            ])->get()->first();
        if ($foods_name_id) {
            $vente->foods_name_id = $foods_name_id->id;
            $vente->factureNum = $factureNum ? $factureNum->factureNum : null;
            $vente->qtt = $request['qtt'];
            $vente->pu = $request['prixAchat'];
            $vente->paye = $request['paye'] >=0 && $request['paye'] <= $request['qtt'] * $request['prixAchat'] ? $request['paye'] : $request['qtt'] * $request['prixAchat'];
            $vente->client_id = $client ? $client->id : null;
            $vente->facture_id = $factureNum ? $factureNum->id : null;
            $vente->update();
            $type = 'modification-facture';
            $message = "commande modifiée.";
        }
        return redirect()->route('ventes.index')->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vente $vente)
    {
        //
    }
}
