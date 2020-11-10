<?php

namespace App\Http\Middleware;

use Closure;

class Staff
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
        if (Auth::check() && Auth::user()->role == 1) {
            return redirect('/dashboard');
        }
        elseif (Auth::check() && Auth::user()->role == 2) { 
            return redirect('/dashboard');
        }
        elseif (Auth::check() && Auth::user()->role == 3) { 
            return redirect('/dashboard');
        }
        else {
            return redirect('/');
        }
    }
}
