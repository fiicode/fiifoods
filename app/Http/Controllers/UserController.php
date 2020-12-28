<?php

namespace App\Http\Controllers;

use App\Model\Option;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $this->authorize('viewAny', User::class);

        $users = User::where([
            ['deleted_at', null],
            ['id', '>', 1]
        ])->get();

        $options = Option::where([
            ['deleted_at', null],
            ['role', true]
        ])->get();
        return view('components.user', compact('users', 'options'));
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
        //$this->authorize('create', User::class);
        
        //dd($request);
        $this->validate($request, [
            'name'     => 'required|min:2',
            'username' => 'required|min:3|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer'

        ]);
        //dd(request('role'));
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
        //$this->authorize('view', $user);
        
        return redirect()->route('users.index')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //$this->authorize('update', $user);

        $this->validate($request, [
            'name'     => 'required|min:2',
            'username' => 'required|min:3',
            'email'    => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer'
        ]);

        if (Auth::user()->id == 1 || Auth::user()->id == $user->id) {
            $user->name = $request['name'];
            $user->username = $request['username'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->role_id = $request['role'];
            $user->update();
            return redirect()->route('users.index')->with('modification-user', 'utilisateur modifié');
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
        $user->delete();

        return redirect()->route('users.index')->with('supression-user', 'utilisateur supprimé');
    }
}
