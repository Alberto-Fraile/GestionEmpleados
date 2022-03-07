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
    public function handle(Request $req, Closure $next)
    {
        $respuesta = ["status" => 1, "msg" => ""];
        $datos = $req->getContent();
        $datos = json_decode($datos);

        if (isset($datos->api_token)) {
            $apitoken = $datos->api_token;
            $user = User::where('api_token', $apitoken)->first();
            //Pasar usuario
            if ($user) {
                $respuesta['status'] = 23;
                $respuesta['msg'] = "Token correcto";
                $req->user = $user;
                return $next($req);
            } else {
                $respuesta['status'] = 24;
                $respuesta['msg'] = "Usuario no encontrado";
            }
        } else {
            $respuesta['status'] = 25;
            $respuesta['msg'] = "Token no introducido";
        }

        return response()->json($respuesta);
    }
}
