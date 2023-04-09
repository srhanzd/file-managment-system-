<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        try {


            if (Auth::user() && Auth::user()->is_admin == 1) {
                return $next($request);
            }

//        return redirect('home')->with('error','ooobs you cant go there ');
            abort(403);

        }
        catch (\Exception $exception){
            return $next($exception->getMessage());
        }
    }

}
