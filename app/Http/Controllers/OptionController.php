<?php

namespace App\Http\Controllers;

use App\Model\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
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
            'product_name' => 'required|min:1',
          
        ]);

        if($request['product_name'] && request('unite')) {
            $option = Option::where('name', $request['product_name'])->where('deleted_at', null)->get()->first();
            if (!$option) {
                Option::firstOrcreate([
                    'name' => $request['product_name'],
                    'unite' => true,
                    'user_id' => Auth::user()->id
                ]);
                $type = 'success-option';
                $message = "Option créée";
            } else {
                $type = 'error-option';
                $message = "Option éxiste déjà.";
            }
            return redirect()->route('achats.index')->with($type, $message);
        }

        if ($request['product_name'] && request('role')) {

            $roles = $request->roles;          

            $option = Option::where('name', $request['product_name'])->where('deleted_at', null)->get()->first();
            if (!$option) {
                $role = Option::firstOrcreate([
                    'name' => $request['product_name'],
                    'role' => true,
                    'user_id' => Auth::user()->id
                ]);

                for ($i = 0; $i < count($roles); $i++) {
                    DB::table('menu_role')->insert([
                        'role_id' => $role->id,
                        'menu_id' => $roles[$i],
                    ]);    
                }

                $type = 'success-option';
                $message = "Option créée";
            } else {
                $type = 'error-option';
                $message = "Option éxiste déjà";
            }
            return redirect()->route('users.index')->with($type, $message);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        if($option->unite) {
            return redirect()->route('achats.index')->with('unite', $option);

        } elseif($option->role) {
            return redirect()->route('users.index')->with('role', $option);

        } else {
            return back();
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        if($option->unite) {

            $option->deleted_at = Date('Y-m-d H:i:s');
            $option->update();
            return redirect()->route('achats.index')->with('supression-option', 'Unité supprimée');

        } elseif($option->role) {

            $option->deleted_at = Date('Y-m-d H:i:s');
            $option->update();
            return redirect()->route('users.index')->with('supression-option', 'Rôle supprimé');

        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        if($option->unite)
        {
            $type = 'modification-option';
            $message = "Unité modifiée.";
            $option->name = $request['product_name'];
            $option->update();
            return redirect()->route('achats.index')->with($type, $message);

        } elseif($option->role){

            $type = 'modification-option';
            $message = "Rôle modifié.";
            $option->name = $request['product_name'];
            $option->update();
            return redirect()->route('users.index')->with($type, $message);

        } else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        //
    }
}
