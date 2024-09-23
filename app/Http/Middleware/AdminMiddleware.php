<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if user is logged in AND user is an admin
        if(Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID){
        //check if user is logged in && check the user role_id to see if its the same as ADMIN_ROLE_ID
        return $next($request); //who we are going to allow to access the admin pages
        }else{
            return redirect()->route('home');
        }
    }
}
