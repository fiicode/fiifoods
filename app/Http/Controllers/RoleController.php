<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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

        if ($request['product_name'] && request('role')) {
            $role = Role::where('name', $request['product_name'])->get()->first();
            if (!$role) {
                Role::firstOrcreate([
                    'name' => $request['product_name'],
                    // 'role' => true,
                    //'user_id' => Auth::user()->id
                ]);
                $type = 'success-role';
                $message = "Option créée.";
            } else {
                $type = 'error-role';
                $message = "Option éxiste déjà.";
            }
            return redirect()->route('users.index')->with($type, $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        
        if ($role->name) {

            return redirect()->route('users.index')->with('role', $role);
        } else {

            return back();
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if ($role->name) {

            $role->deleted_at = Date('Y-m-d H:i:s');
            $role->update();
            return redirect()->route('users.index')->with('supression-role', 'Rôle supprimé');
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name) {

            $type = 'modification-role';
            $message = "Rôle modifié.";
            $role->name = $request['product_name'];
            $role->update();

            return redirect()->route('users.index')->with($type, $message);

        } else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
