<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;


use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class LoginController extends Controller
{
    public function __construct()
	{
   	
	}
	public function getIndex()
	{
		
		return view('peticion.login.index');	
		}
   public function validar_datos(Request $request)
   {
	 //  print_r(sha1($_POST["pass"])); exit;
	   $this->validate
	   (
	   $request,
	   [
	  'user'=>'required',
	  'pass'=>'required|min:7',
	   ]
	   );
	   $pass=sha1($request->get('pass'));
	                  $validar=DB::table('usuarios as u')
	                    ->join('perfil as p','p.idperfil','=','u.idperfil')
			              ->where('u.user','=',$request->get('user'))
						  ->where('u.contrasena','=',$pass)
						  ->first();
						  
	 if(sizeof($validar)==0)
	 {
		 return Redirect::to('peticion/login/')->with('mensaje','Datos incorrectos, por favor vuelva a validar su informacion correctamente');
	 }
	   else
	   {
		  $request->session()->put('id',$validar->idusuario);
		  $request->session()->put('perfil',$validar->idperfil);
		  $request->session()->put('user',$validar->user);
		  $request->session()->put('img',$validar->imagen);
		   return Redirect::to('peticion/ventas');
	   }
	   
   }
   public function salir(Request $request)
   {
	  $request->session()->flush();
	  return Redirect::to('peticion/login');
   }
	}
	

