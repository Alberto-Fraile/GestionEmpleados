<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerificarApiToken
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
        //Buscar al usuario
        $apitoken = $request->api_token;

        $user = User::where('api_token', $apitoken)->first();

        if(!$user) {
            $request['status'] = 0;
            $request['msg'] = "Se ha producido un error: ";  

        }else{
            $request->user = $user;
            return $next($request);
        }
        return response()->json($request);
    }
}
