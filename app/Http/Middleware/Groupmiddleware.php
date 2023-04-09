<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Groupmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {


            if ($request->group != null) {
                $group = Group::query()->where('id', '=', $request->group)->first();

                $val = $group->users()->where('user_id', '=', Auth::user()->id)->get();
                if (Auth::user()->is_admin == 1) {
                    return $next($request);
                } else if ($val->isEmpty()) {
                    abort(403);

                } else {
                    return $next($request);
                }
            }
            $group = Group::query()->where('id', '=', $request->id)->first();

            $val = $group->users()->where('user_id', '=', Auth::user()->id)->get();
            if (Auth::user()->is_admin == 1) {
                return $next($request);
            } else if ($val->isEmpty()) {
                abort(403);

            } else {
                return $next($request);
            }
        }
        catch (\Exception $exception){
            return $next($exception->getMessage());
        }
}
}
