<?php

namespace App\Http\Controllers;

use App\Model\Fournisseur;
use App\Model\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersementFournisseurController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function show(Fournisseur $id)
    {
        return redirect()->route('activiste')->with('fournisseurtVersemnt', $id);
    }
    public function versement(Request $request)
    {
        $fournisseur = Fournisseur::select('id')
            ->where([
                ['nom', $request['nom']],
                ['phone', $request['phone']]
            ])->get()->first();
        if ($fournisseur) {
            Option::create([
                'name' => $request['mtt'],
                'versemFournisseur' => true,
                'fournisseur_id' => $fournisseur->id,
                'user_id' => Auth::user()->id
            ]);
            $type = 'success-versement';
        }else {
            $type = 'error-versement';
        }

        return redirect()->route('activiste')->with($type, 'commade supprimé');
    }
}