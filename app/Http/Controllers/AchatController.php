<?php

namespace App\Http\Controllers;

use App\Model\Achat;
use App\Model\FoodsName;
use App\Model\Fournisseur;
use App\Model\Option;
use App\Model\Order;
use Illuminate\Http\Request;

class AchatController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::where([
                ['deleted_at', null],
                ['unite', true]
            ])->get();
        $produits = FoodsName::where([
                ['deleted_at', null]
            ])->get();
        $achats = Achat::where([
            ['deleted_at', null],
            ['created_at', '>=', Date('Y-m-d') . ' 00:00:00'],
        ])->get();
        $fournisseurs = Fournisseur::select('nom')->where('deleted_at', null)->get();

        $tab = [];
        foreach ($fournisseurs as $fournisseur) {
            $tab[] = $fournisseur->nom;
        }
        $fournisseurs = collect($tab)->toJson();
        return view('components.achat', compact('options', 'produits', 'achats', 'fournisseurs'));
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
            'prixVente' => 'nullable|numeric|min:0',
            'orderId'   => 'nullable|min:2'
        ]);
        $fournisseur = null;
        $orderId = null;
        if ($request['nom']) {
            $fournisseur = Fournisseur::where([
                ['nom', $request['nom']],
                ['phone', $request['phone']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$fournisseur) {
                Fournisseur::firstOrcreate([
                    'nom' => $request['nom'],
                    'phone' => isset($request['phone']) ? $request['phone'] : null,
                    'user_id' => \Auth::user()->id
                ]);
                $fournisseur = Fournisseur::where([
                    ['nom', $request['nom']],
                    ['phone', $request['phone']]
                ])->get()->first();
            }
        }
        if ($request['orderId']) {
            $orderId = Order::where([
                ['orderNum', $request['orderId']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$orderId) {
                Order::create([
                    'orderNum' => $request['orderId'],
                    'user_id' => \Auth::user()->id
                ]);
                $orderId = Order::where([
                    ['orderNum', $request['orderId']],
                    ['deleted_at', null]
                ])->get()->first();
            }
        }
        $type = 'error-commande';
        $message = "commande existe déjà.";

        $foods_name_id = FoodsName::select('id', 'unite_id')
            ->where([
                ['deleted_at', null],
                ['id', $request['foodsName']]
            ])->get()->first();
        if ($foods_name_id) {
            Achat::create([
                'foods_name_id' => $foods_name_id->id,
                'code' => $orderId ? $orderId->orderNum : null,
                'qtt' => $request['qtt'],
                //'unity' => $foods_name_id->unite_id,
                'priceOfPurchase' => $request['prixAchat'],
                'sellingPrice' => $request['prixVente'] ? $request['prixVente'] : 0,
                'paye' => $request['paye'] >=0 && $request['paye'] <= $request['qtt'] * $request['prixAchat'] ? $request['paye'] : $request['qtt'] * $request['prixAchat'],
                'fournisseur_id' => $fournisseur ? $fournisseur->id : null,
                'order_id' => $orderId ? $orderId->id : null,
                'user_id' => \Auth::user()->id
            ]);
            $type = 'success-commande';
            $message = "commande existe déjà.";
        }
        return redirect()->route('achats.index')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function show(Achat $achat)
    {
        return redirect()->route('achats.index')->with('achat', $achat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function edit(Achat $achat)
    {
        $achat->deleted_at = Date('Y-m-d H:i:s');
        $achat->update();
        return redirect()->route('achats.index')->with('supression-commande', 'commade supprimé');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achat $achat)
    {
        $fournisseur = null;
        $orderId = null;
        if ($request['nom']) {
            $fournisseur = Fournisseur::where([
                ['nom', $request['nom']],
                ['phone', $request['phone']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$fournisseur) {
                Fournisseur::firstOrcreate([
                    'nom' => $request['nom'],
                    'phone' => isset($request['phone']) ? $request['phone'] : null,
                    'user_id' => \Auth::user()->id
                ]);
                $fournisseur = Fournisseur::where([
                    ['nom', $request['nom']],
                    ['phone', $request['phone']]
                ])->get()->first();
            }
        }
        if ($request['orderId']) {
            $orderId = Order::where([
                ['orderNum', $request['orderId']],
                ['deleted_at', null]
            ])->get()->first();
            if (!$orderId) {
                Order::create([
                    'orderNum' => $request['orderId'],
                    'user_id' => \Auth::user()->id
                ]);
                $orderId = Order::where([
                    ['orderNum', $request['orderId']],
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
            $achat->foods_name_id = $foods_name_id->id;
            $achat->code = $orderId ? $orderId->orderNum : null;
            $achat->qtt = $request['qtt'];
            //$achat->unity = $foods_name_id->unite_id;
            $achat->priceOfPurchase = $request['prixAchat'];
            $achat->sellingPrice = $request['prixVente'] ? $request['prixVente'] : 0;
            $achat->paye = $request['paye'] >=0 && $request['paye'] <= $request['qtt'] * $request['prixAchat'] ? $request['paye'] : $request['qtt'] * $request['prixAchat'];
            $achat->fournisseur_id = $fournisseur ? $fournisseur->id : null;
            $achat->order_id = $orderId ? $orderId->id : null;
            $achat->update();
            $type = 'modification-commande';
            $message = "commande modifiée.";
        }
        return redirect()->route('achats.index')->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $achat)
    {
        dd($achat);
    }
}
