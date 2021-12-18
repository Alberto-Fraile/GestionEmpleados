<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ValidarPermisoUsuario
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
        //Comprobar los permisos
        if($request->user->puesto == 'directivo' || $request->user->puesto == 'rrhh'){
            return $next($request);
        }else {
            $request['status'] = 0;
            $request['msg'] = "No tienes permisos para realizar esta funcion "; 
        }
        return response()->json($request);
    }
}
