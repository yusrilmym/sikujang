<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSysdevOnly', function($user){
            return $user->role === 'sysdev';
        });

        Gate::define('isSuperAdminPlus', function($user){
            return $user->role === 'super-admin-plus' || $user->role === 'sysdev';
        });

        Gate::define('isSuperAdmin', function($user){
            return $user->role === 'super-admin' || $user->role === 'sysdev';
        });

        Gate::define('isSuperAdminAndPlus', function($user){
            return $user->role === 'super-admin' || $user->role === 'super-admin-plus' || $user->role === 'sysdev';
        });

        Gate::define('isAdmin', function($user){
            return $user->role === 'admin' || $user->role === 'sysdev';
        });
        Gate::define('isUser', function($user){
            return $user->role === 'user' || $user->role === 'sysdev';
        });

        Passport::routes();

        //
    }
}
