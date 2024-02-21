<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Setting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {
        $attribution = 'module_setting_'.$action;

        /*
         * Empêcher l'utilisateur d'effectuer l'action s'il n'est pas autorisé.
         */

        if(auth()->user()->espace->{$attribution} != 1) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Vous n\'etes pas autorisé à accéder à cette section');
            return redirect()->back();
        }

        return $next($request);
    }
}
