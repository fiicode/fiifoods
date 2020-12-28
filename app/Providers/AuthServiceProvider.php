<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        // Gate::define('create-users', function ($user) {
        //     return $user->isAdmin();
        // });

        // Gate::define('show-users', function ($user) {
        //     return $user->isAdmin();
        // });

        // Gate::define('update-users', function ($user) {
        //     return $user->isAdmin();
        // });

        // Gate::define('delete-users', function ($user) {
        //     return $user->isAdmin();
        // });
    }
}
