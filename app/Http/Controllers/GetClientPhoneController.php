<?php

namespace App\Http\Controllers;

use App\Model\Client;
use Illuminate\Http\Request;

class GetClientPhoneController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function phone(Request $request, $id)
    {
        $client = Client::select('phone')->where('nom', $request['query'])->get()->first();
        return response()->json(['client' => $client->phone], 200);
    }
}