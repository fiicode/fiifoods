<?php

namespace App\Http\Controllers;

use App\Model\FoodsName;
use App\Model\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodsNameController extends Controller
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
    public function index(FoodsName $foods_name)
    {
        // $foodsNames = FoodsName::all();
        // return view('components.showfoods', compact('foods_name'));
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
            'foodsName' => 'required|min:2',
            'inventaire' => 'nullable|min:2',
            'unite' => 'nullable|integer|min:1'
        ]);
        $foodsName = FoodsName::where([
            ['foodsName', $request['foodsName']],
            ['deleted_at', null]
        ])->get()->first();
        $unite_id = Option::select('id')
            ->where([
                ['deleted_at', null],
                ['unite', true],
                ['id', $request['unite']]
            ])->get()->first();
        if (!$foodsName) {
            FoodsName::firstOrcreate([
                'foodsName' => $request['foodsName'],
                'unite_id' => $unite_id ? $unite_id->id : null,
                'inventaire' => isset($request['inventaire']) ? true: false,
                'user_id' => Auth::user()->id
            ]);
            $type = 'success-foodsName';
            $message = "FoodsName créé.";
        }else {
            $type = 'error-foodsName';
            $message = "FoodsName existe déjà.";
        }
        return redirect()->route('achats.index')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FoodsName  $foodsName
     * @return \Illuminate\Http\Response
     */
    public function show(FoodsName $foodsName)
    {
        return redirect()->route('achats.index')->with('produit', $foodsName);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FoodsName  $foodsName
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodsName $foodsName)
    {
        $foodsName->deleted_at = Date('Y-m-d H:i:s');
        $foodsName->update();
        return redirect()->route('achats.index')->with('supression-produit', 'commade supprimé');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FoodsName  $foodsName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodsName $foodsName)
    {
        $foodsNam = FoodsName::where([
            ['foodsName', $request['foodsName']],
            ['deleted_at', null]
        ])->get()->first();
        $unite_id = Option::select('id')
            ->where([
                ['deleted_at', null],
                ['unite', true],
                ['id', $request['unite']]
            ])->get()->first();

        if ($foodsNam) {
            $type = 'error-foodsName';
            $message = "FoodsName existe déjà.";
            $foodsName->unite_id = $unite_id ? $unite_id->id : null;
            $foodsName->inventaire = isset($request['inventaire']) ? true: false;
            $foodsName->update();
        }else {
            $foodsName->unite_id = $unite_id ? $unite_id->id : null;
            $foodsName->inventaire = isset($request['inventaire']) ? true: false;
            $foodsName->foodsName = $request['foodsName'];
            $foodsName->update();
            $type = 'modification-foodsName';
            $message = "FoodsName créée.";
        }
        return redirect()->route('achats.index')->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FoodsName  $foodsName
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodsName $foodsName)
    {
        //
    }
}
