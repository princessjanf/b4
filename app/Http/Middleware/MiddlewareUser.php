<?php

namespace App\Http\Middleware;

use Closure;
use SSO\SSO;
use Illuminate\Support\Facades\DB;
class MiddlewareUser
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
        if (SSO::check()){
            return $next($request);

        }   
        return redirect('/login');
    }
}
