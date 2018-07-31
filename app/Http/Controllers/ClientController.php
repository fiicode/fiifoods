<?php

namespace App\Http\Controllers;

use App\Model\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'nomClient'       => 'required|min:2',
            'phoneClient'     => 'nullable|min:2',
        ]);
        $client = Client::where([
            ['nom', $request['nomClient']],
            ['phone', $request['phoneClient']],
            ['deleted_at', null]
        ])->get()->first();
        $type = 'error-client';
        $message = "commande existe déjà.";
        if (!$client) {
            Client::firstOrcreate([
                'nom' => $request['nomClient'],
                'phone' => isset($request['phoneClient']) ? $request['phoneClient'] : null,
                'user_id' => \Auth::user()->id
            ]);
            $type = 'success-client';
            $message = "commande existe déjà.";
        }
        return redirect()->route('activiste')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return redirect()->route('activiste')->with('client', $client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $client->deleted_at = Date('Y-m-d H:i:s');
        $client->update();
        return redirect()->route('activiste')->with('supression-client', 'commade supprimé');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->nom = $request['nomClient'];
        $client->phone = $request['phoneClient'];
        $client->update();
        return redirect()->route('activiste')->with('modification-client', 'commade supprimé');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
