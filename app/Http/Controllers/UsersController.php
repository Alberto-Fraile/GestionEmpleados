<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\Password;

class UsersController extends Controller
{
    public function register(Request $req){

		$respuesta = ["status" => 1, "msg" => ""];

        $validator = validator::make(json_decode($req->getContent(),true
    	), 
        	['name' => 'required|max:55',
        	 'email' => 'required|email|unique:App\Models\User,email|max:30',
        	 'password' => 'required|regex:/(?=.*[a-z)(?=.*[A-Z])(?=.*[0-9]).{6,}/',
        	 'puesto' => 'required|in:empleado,directivo,rrhh',
        	 'salario' => 'required|numeric',
        	 'biografia' => 'required|max:100'
        	]);

        if ($validator->fails()){
        	$respuesta['status'] = 0;
        	$respuesta['msg'] = $validator->errors();

        }else {
	        $datos = $req->getContent();
	        $datos = json_decode($datos);
	        $users = new User();

	        $users->name = $datos->name;
	        $users->email = $datos->email;
	        $users->password = Hash::make($datos->password);
	        $users->puesto = $datos->puesto;
	        $users->salario = $datos->salario;
	        $users->biografia = $datos->biografia;	

	    	
	        try{
	            $users->save();
	            $respuesta['msg'] = "Usuario guardado con id ".$users->id;
	        }catch(\Exception $e){
	            $respuesta['status'] = 0;
	            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
	        }

        }

	    return response()->json($respuesta);
    }

    public function login(Request $req){

    	




    }
}


