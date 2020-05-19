<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /*
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     *
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    */

    public function handle($request, Closure $next, $guard = null)
    {
        // if the session does not have 'authenticated' forget the user and redirect to login
        if ($request->session()->get('authenticated',false) === true)
        {
            return $next($request);
        }
        $request->session()->forget('authenticated');
        $request->session()->forget('user');
        return redirect()->action("LoginController@showLoginForm")->with('error', 'Tu sesión ha expirado');
    }

}
