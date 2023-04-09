<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {


            $response = $next($request);//->this is the response
            if (app()->environment('local')) {
                if (Auth::user()) {


                    $log = [
                        'URI' => $request->getUri(),
                        'METHOD' => $request->getMethod(),
                        'REQUEST_BODY' => $request->all(),
                        'RESPONSE' => $response->getContent(),
                        'USER_ID' => Auth::user()->id,
                        'USER_NAME' => Auth::user()->name,
                    ];
                } else {
                    $log = [
                        'URI' => $request->getUri(),
                        'METHOD' => $request->getMethod(),
                        'REQUEST_BODY' => $request->all(),
                        'RESPONSE' => $response,
                    ];
                }
                Log::build([
                    'driver' => 'daily',
                    'path' => storage_path('logs/all_system_logs.log'),
                ])->info(json_encode($log));
            }
            return $response;
        }
        catch (\Exception $exception){
            return $next($exception->getMessage());
        }
    }

}
