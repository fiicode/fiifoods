<?php

namespace App\Http\Controllers;

use App\Model\Fournisseur;
use Illuminate\Http\Request;

class GetFournisseurPhoneController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function phone(Request $request, $id)
    {
        $supplier = Fournisseur::select('phone')->where('nom', $request['query'])->get()->first();
        return response()->json(['fournisseur' => $supplier->phone], 200);
    }
}