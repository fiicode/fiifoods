<?php

namespace App\Http\Controllers;

use App\Model\Client;
use App\Model\Option;
use Illuminate\Http\Request;

class VersementClientController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function show(Client $id)
    {
        return redirect()->route('activiste')->with('clientVersemnt', $id);
    }
    public function versement(Request $request)
    {
        $client = Client::select('id')
            ->where([
                ['nom', $request['nom']],
                ['phone', $request['phone']]
            ])->get()->first();
        if ($client) {
            Option::create([
                'name' => $request['mtt'],
                'versemClient' => true,
                'client_id' => $client->id,
                'user_id' => \Auth::user()->id
            ]);
            $type = 'success-versement';
        }else {
            $type = 'error-versement';
        }

        return redirect()->route('activiste')->with($type, 'commade supprimée');
    }
}