<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class Setup
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
        if (env('APP_KEY') === null || empty(env('APP_KEY')) && empty(config('app.key'))){
            Artisan::call('key:generate');
            Artisan::call('config:cache');
        }

        $setupStatus = setupStatus();

        //Verification de la configuration de l'app
        if ($request->is('install/*')){
            if($setupStatus){
                return redirect()->route('dashboard');
            }
            return $next($request);
        }

        if(!$setupStatus){
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}
