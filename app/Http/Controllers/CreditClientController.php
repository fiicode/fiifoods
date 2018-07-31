<?php

namespace App\Http\Controllers;

use App\Model\Client;
use App\Model\Option;
use Illuminate\Http\Request;

class CreditClientController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function credit(Request $request)
    {
        $client = Client::select('id')
            ->where([
                ['nom', $request['nom']],
                ['phone', $request['phone']]
            ])->get()->first();
        if ($client) {
            Option::create([
                'name' => $request['mtt'],
                'creditClient' => true,
                'client_id' => $client->id,
                'user_id' => \Auth::user()->id
            ]);
            $type = 'success-credit';
        }else {
            $type = 'error-credit';
        }

        return redirect()->route('activiste')->with($type, 'commade supprimé');
    }
}