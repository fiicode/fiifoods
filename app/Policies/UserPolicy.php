<?php

namespace App\Policies;

use App\Model\Option;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        
        (Auth::user()->role_id);
        //$roles = Option::select('name')->where('role', 1)->take(5)->get();
        //dd($roles);
        // $options = Option::where([
        //     ['deleted_at', null],
        //     ['role', true]
        // ])->get();

        //return in_array($roles, $user->role_id,); 
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC',
        ]); 
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC',
        ]); 
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->password, [    
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC', 
        ]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC', 

        ]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC', 
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC',
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return in_array($user->password, [
            '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC',
        ]);
    }
}
