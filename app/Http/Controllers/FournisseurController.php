<?php

namespace App\Http\Controllers;

use App\Model\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
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
    public function index(Fournisseur $fournisseur)
    {
        return view('components.fournisseur', compact('fournisseur'));
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
            'nom'       => 'required|min:2',
            'phone'     => 'nullable|min:2',
        ]);
        $fournisseur = Fournisseur::where([
            ['nom', $request['nom']],
            ['phone', $request['phone']],
            ['deleted_at', null]
        ])->get()->first();
        $type = 'error-fournisseur';
        $message = "commande existe déjà.";
        if (!$fournisseur) {
            Fournisseur::firstOrcreate([
                'nom' => $request['nom'],
                'phone' => isset($request['phone']) ? $request['phone'] : null,
                'user_id' => \Auth::user()->id
            ]);
            $type = 'success-fournisseur';
            $message = "commande existe déjà.";
        }
        return redirect()->route('activiste')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        return redirect()->route('activiste')->with('fournisseur', $fournisseur);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {
        $fournisseur->deleted_at = Date('Y-m-d H:i:s');
        $fournisseur->update();
        return redirect()->route('activiste')->with('supression-fournisseur', 'commade supprimée');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $fournisseur->nom = $request['nom'];
        $fournisseur->phone = $request['phone'];
        $fournisseur->update();
        return redirect()->route('activiste')->with('modification-fournisseur', 'commade supprimée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        //
    }
}
