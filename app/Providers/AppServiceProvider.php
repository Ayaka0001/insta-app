<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::define('admin', function($user){ //GATE returns true or false
            // need the variable $user to use the $user->role_id
            //'admin' is the name of the gate
            return $user->role_id == User::ADMIN_ROLE_ID;
            //if user ->role_id is the same as ADMIN_ROLE_ID, it returns true
        });
    }
}
