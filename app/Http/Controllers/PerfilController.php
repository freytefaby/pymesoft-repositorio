<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Perfil;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use hhfarm\Http\Requests\PerfilFormRequest;
use DB;
use Session;
class PerfilController extends Controller
{
   public function __construct()
   {
	   
   }
   public function index(Request $request)
   {
	 
	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',21)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1  )
	   {

		return view("peticion.permiso.crear_perfil");  

							 }   
	   else
{
return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
		   
	   }




	   
   }

	  
 
		  
		  
		  }
		  else
		  {
return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		  }
	 
   }
   
     public function store(PerfilFormRequest $request)
   {
	   
	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',21)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1 )
	   {

		$perfil=new Perfil;
		$perfil->perfildesc=$request->get('perfil');
		$perfil->save();
		return Redirect::to('peticion/permisos')->with('mensaje','Perfil creado correctamente.');


							 }   
	   else
{
return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
		   
	   }




	   
   }

	  
 
		  
		  
		  }
		  else
		  {
return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		  }
		
   
	  
   }
   
  
}
