<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Giaptt\Oidcda\Authen;

class IsPatientCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if( Authen::getPositionUser() == 1){
            return $next($request);
        }

        return Redirect('/home');
    }
}
