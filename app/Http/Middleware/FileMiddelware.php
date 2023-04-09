<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileMiddelware
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


            //group_id
            if (is_string($request->ids)) {
                $ids = array_map('intval', explode(',', $request->ids));
            } else
                $ids = $request->ids;
            if ($request->group_id != null) {
                $group = Group::query()->where('id', '=', $request->group_id)->first();

                $val = $group->users()->where('user_id', '=', Auth::user()->id)->get();
                if (Auth::user()->is_admin == 1) {
                    return $next($request);
                } else if ($val->isEmpty()) {
                    abort(403);

                } else {
                    return $next($request);
                }
            } else {
                $files = File::query()->whereIn('id', $ids)->
                where('user_id', '=', Auth::user()->id);
                if ($files->count() != count($ids)) {
                    abort(403);
                }
                if (Auth::user()->is_admin == 1) {
                    return $next($request);
                } else {
                    return $next($request);
                }

            }
        }
        catch (\Exception $exception){
            return $next($exception->getMessage());
        }
}
}
