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
	        $user = new User();

	        $user->name = $datos->name;
	        $user->email = $datos->email;
	        $user->password = Hash::make($datos->password);
	        $user->puesto = $datos->puesto;
	        $user->salario = $datos->salario;
	        $user->biografia = $datos->biografia;	

	    	
	        try{
	            $user->save();
	            $respuesta['msg'] = "Usuario guardado con id ".$user->id;
	        }catch(\Exception $e){
	            $respuesta['status'] = 0;
	            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
	        }

        }

	    return response()->json($respuesta);
    }

    public function login(Request $req){
		$respuesta = ["status" => 1, "msg" => ""];

		$datos = $req->getContent();
		$datos = json_decode($datos);
    	
    	$email = $datos->email;

		//Encontrar al usuario con ese email
		$user = User::where('email', '=', $email)->first();

		//Pasar la vadilación
		if($user){
		//Comprobar la contraseña
			if (Hash::check($datos->password, $user->password)) {
	            //Generar Api Token
	            do{
	        		$apitoken = Hash::make($user->id.now());

	            }while(User::where('api_token', $apitoken)->first());

	            $user->api_token = $apitoken;
	            $user->save();
	            $respuesta['msg'] = "Login correcto".$user->api_token;


			}else {
	        	$respuesta['status'] = 0;
		        $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();		
			}
		}else{
			$respuesta['status'] = 0;
	        $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();	
		}
		return response()->json($respuesta);
    }

    public function recuperarPassword(Request $req){ 
		$respuesta = ["status" => 1, "msg" => ""];

		$datos = $req->getContent();
		$datos = json_decode($datos);

		$email = $datos->email;
		
		//Encontrar al usuario con ese email
		$user = User::where('email', $email)->first();
		
		//Pasar la vadilación
		if($user){
			//Si encontramos al usuario
			$user->api_token = null;

			$password = ;

			$user->password = Hash::make($password);
			$user->save();
			$respuesta['msg'] = "Se ha enviado un mail de recuperación";

   		}else{
			$respuesta['status'] = 0;
	        $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
   		}
   		return response()->json($respuesta);
    }
}


