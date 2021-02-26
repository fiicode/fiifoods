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
use App\Model\Search;
use App\Model\Vente;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchs = Search::all();
        return view('home')->with('searchs', $searchs);
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $vente = new Vente();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $search = request('search');

        $this->validate($request, ['search' => 'required']);
        
        // dd($search);
        $achats = Achat::select('id', 'qtt', 'code', 'foods_name_id', 'priceOfPurchase', 'sellingPrice', 'reste', 'mntTotalAchat', 'mntTotalVent', 'created_at')
            ->where('foods_name_id','Like', '%'.$search. '%')
            ->OrWhere('code', 'Like', '%' . $search . '%')
            ->OrWhere('qtt', 'Like', '%' . $search . '%')
            ->OrWhere('priceOfPurchase', 'Like', '%' . $search . '%')
            ->OrWhere('sellingPrice', 'Like', '%' . $search . '%')
            ->OrWhere('paye', 'Like', '%' . $search . '%')
            ->OrWhere('fournisseur_id', 'Like', '%' . $search . '%')
            ->OrWhere('mntTotalAchat', 'Like', '%' . $search . '%')
            ->OrWhere('mntTotalVent', 'Like', '%' . $search . '%')
            ->OrWhere('reste', 'Like', '%' . $search . '%')
            ->OrWhere('order_id', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($achats);

        $clients = Client::select('id', 'nom', 'phone', 'email', 'created_at')
            ->where('nom', 'Like', '%' . $search . '%')
            ->OrWhere('adress', 'Like', '%' . $search . '%')
            ->OrWhere('phone', 'Like', '%' . $search . '%')
            ->OrWhere('email', 'Like', '%' . $search . '%')
            ->OrWhere('entrepris', 'Like', '%' . $search . '%')
            ->OrWhere('webSite', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($clients);


        $depenses = Depense::select('id', 'montant', 'description', 'created_at')
            ->where('description', 'Like', '%' . $search . '%')
            ->OrWhere('montant', 'Like', '%' . $search . '%')
            ->OrWhere('entite', 'Like', '%' . $search . '%')
            ->OrWhere('motif', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($depenses);

        $factures = Facture::select('id', 'factureNum', 'user_id', 'created_at')
            ->where('factureNum', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();
        // dd($factures);

        $foods_names = FoodsName::select('id', 'foodsName', 'inventaire', 'created_at')
            ->where('foodsName', 'Like', '%' . $search . '%')
            ->OrWhere('unite_id', 'Like', '%' . $search . '%')
            ->OrWhere('inventaire', 'Like', '%' . $search . '%')
            ->OrWhere('avatar', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();
            
        // dd($foods_name);

        $fournisseurs = Fournisseur::select('id', 'nom', 'phone', 'created_at')
            ->where('nom', 'Like', '%' . $search . '%')
            ->OrWhere('adress', 'Like', '%' . $search . '%')
            ->OrWhere('phone', 'Like', '%' . $search . '%')
            ->OrWhere('email', 'Like', '%' . $search . '%')
            ->OrWhere('entrepris', 'Like', '%' . $search . '%')
            ->OrWhere('webSite', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($fournisseurs);

        $membres = Membre::select('id', 'nom', 'phone', 'created_at')
            ->where('nom', 'Like', '%' . $search . '%')
            ->OrWhere('adress', 'Like', '%' . $search . '%')
            ->OrWhere('phone', 'Like', '%' . $search . '%')
            ->OrWhere('email', 'Like', '%' . $search . '%')
            ->OrWhere('entrepris', 'Like', '%' . $search . '%')
            ->OrWhere('webSite', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($membres);

        $options = Option::select('id', 'name', 'motif', 'created_at')
            ->where('name', 'Like', '%' . $search . '%')
            ->OrWhere('unite', 'Like', '%' . $search . '%')
            ->OrWhere('entite', 'Like', '%' . $search . '%')
            ->OrWhere('motif', 'Like', '%' . $search . '%')
            ->OrWhere('versemFournisseur', 'Like', '%' . $search . '%')
            ->OrWhere('creditFournisseur', 'Like', '%' . $search . '%')
            ->OrWhere('versemClient', 'Like', '%' . $search . '%')
            ->OrWhere('creditClient', 'Like', '%' . $search . '%')
            ->OrWhere('client_id', 'Like', '%' . $search . '%')
            ->OrWhere('fournisseur_id', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($options);

        $orders = Order::select('id', 'orderNum', 'user_id',  'created_at')
            ->where('orderNum', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();

        // dd($orders);

        $ventes = Vente::select('id', 'foods_name_id' ,'factureNum', 'qtt', 'pu', 'mtt', 'reste', 'created_at')
            ->where('foods_name_id', 'Like', '%' . $search . '%')
            ->OrWhere('factureNum', 'Like', '%' . $search . '%')
            ->OrWhere('qtt', 'Like', '%' . $search . '%')
            ->OrWhere('pu', 'Like', '%' . $search . '%')
            ->OrWhere('paye', 'Like', '%' . $search . '%')
            ->OrWhere('client_id', 'Like', '%' . $search . '%')
            ->OrWhere('mtt', 'Like', '%' . $search . '%')
            ->OrWhere('reste', 'Like', '%' . $search . '%')
            ->OrWhere('facture_id', 'Like', '%' . $search . '%')
            ->OrWhere('user_id', 'Like', '%' . $search . '%')
            ->OrWhere('created_at', 'Like', '%' . $search . '%')
            ->OrWhere('updated_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted_at', 'Like', '%' . $search . '%')
            ->OrWhere('deleted', 'Like', '%' . $search . '%')
            ->OrWhere('archived', 'Like', '%' . $search . '%')
            ->get();
        
        // dd($ventes);

        Search::create([
            'search' => $search
        ]);


        // $searchs = Search::select('search');

        return redirect()->route('home')
            ->with('achats', $achats)
            ->with('clients', $clients)
            ->with('depenses', $depenses)
            ->with('factures', $factures)
            ->with('foods_names', $foods_names)
            ->with('fournisseurs', $fournisseurs)
            ->with('membres', $membres)
            ->with('options',$options)
            ->with('orders', $orders)
            ->with('ventes', $ventes)
            // ->with('searchs', $searchs)
            
        ;
    }


    
}
