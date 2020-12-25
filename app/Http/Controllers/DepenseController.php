<?php

namespace App\Http\Controllers;

use App\Model\Depense;
use App\Model\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
    /**
     * DepenseController constructor.
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
        $depenses = Depense::where('deleted_at', null)->where('created_at', '>=', Date('Y-m-d') . ' 00:00:00')->get();
        $entites = Option::where([
            ['deleted_at', null],
            ['entite', true]
        ])->get();
        $motifs = Option::where([
            ['deleted_at', null],
            ['motif', true]
        ])->get();
        return view('components.depense', compact('entites', 'motifs', 'depenses'));
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
           'description' => 'nullable|min:2',
           'montant' => 'required|numeric|min:0'
        ]);
        Depense::create([
            'description' => $request['description'],
            'montant' => $request['montant'],
            'entite' => $request['entite'],
            'motif' => $request['motif'],
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('depense.index')->with('success-depense', 'creer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function edit(Depense $depense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depense $depense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depense $depense)
    {
        //
    }
}
