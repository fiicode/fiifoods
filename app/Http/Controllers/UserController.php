<?php

namespace App\Http\Controllers;

use App\Model\Option;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() 
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::where([
            ['deleted_at', null],
            ['id', '>', 2]
        ])->get();

        $options = Option::where([
            ['deleted_at', null],
            ['role', true],
        ])->get();

        $roles = Option::where([
            ['deleted_at', null],
            ['menu', true],
            ['user_id', null]
        ])->get();
        
        return view('components.user', compact('users', 'options', 'roles'));
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
            'name'     => 'required|min:2',
            'username' => 'required|min:3|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'integer',
        ]);
        
        $type = 'error-user';
        $message = 'created!';

        if (User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $request['role']
        ])) {
            $type = 'success-user';
            $message = 'success';
        }

        return redirect()
            ->route('users.index')
            ->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {        
        return redirect()->route('users.index')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->deleted_at = Date('Y-m-d H:i:s');
        $user->update();
        return redirect()->route('users.index')->with('supression-user', 'Utilisateur supprimé');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'     => 'required|min:2',
            'username' => 'required|min:3',
            'email'    => 'email|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'integer'
        ]);

        if (Auth::user()->id == 1 || Auth::user()->id == 2 || (access_order() && access_anal() && access_sell()) ) {
            $user->name = $request['name'];
            $user->username = $request['username'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->role_id = $request['role'];
            $user->update();
            return redirect()->route('users.index')->with('modification-user', 'utilisateur modifié');

        } elseif(access_order() || access_anal() || access_sell()) {
            $user->name = $request['name'];
            $user->username = $request['username'];
            $user->password = bcrypt($request['password']);
            $user->update();
            return redirect()->route('users.index')->with('modification-user', 'utilisateur modifié');

        } else {
            return back();
        }
        return redirect()->route('users.index')->with('error-user', 'utilisateur modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return redirect()->route('users.index')->with('supression-user', 'utilisateur supprimé');
    }
}
