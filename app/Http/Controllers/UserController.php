<?php

namespace App\Http\Controllers;

use App\User;
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
        $users = User::where([
            ['deleted_at', null],
            ['id', '>', 1]
        ])->get();
        return view('components.user', compact('users'));
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
//        dd($request);
        $this->validate($request, [
            'name'     => 'required|min:2',
            'username' => 'required|min:3|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:3|confirmed'
        ]);
        $type = 'error-user';
        $message = 'created!';
        if (User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ])) {
            $type = 'success-user';
            $message = 'success';
        }

        //
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
        $this->validate($request, [
            'name'     => 'required|min:2',
            'password' => 'required|min:3|confirmed'
        ]);
        if (\Auth::user()->id == 1 || \Auth::user()->id == $user->id) {
            $user->name = $request['name'];
            $user->password = bcrypt($request['password']);
            $user->update();
            return redirect()->route('users.index')->with('modification-user', 'commade supprimé');
        }
        return redirect()->route('users.index')->with('error-user', 'commade supprimé');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
