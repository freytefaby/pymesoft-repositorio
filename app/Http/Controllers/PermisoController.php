<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Base;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\BaseFormRequest;
use DB;
use Session;
class PermisoController extends Controller
{
   public function __construct()
   {
	   
   }
   public function index(Request $request)
   {
	 if($request->session()->has('id'))
	 {
	   
		   
			   if($request->session()->get('perfil')==1  )
			   {
			   
			   
			 if($request)
	 {
		
    $permisos=DB::table('permiso as p')
             ->join('recurso as r','r.idrecurso','=','p.idrecurso')
             ->get();
	    return view('peticion.permiso.index',["permisos"=>$permisos]);
		 
	 }		 
			   
			   
			   
			   }   
			   else
			   {
				     return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
		   
		   
		   }
		   else
		   {
			    return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }
	 
   }
     
   
    
     public function edit(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

 return view("peticion.base.edit",["base"=>Base::findOrFail($id)]);  

                                     }   
			   Else
{
 return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
		   
		   
		   }
		   else
		   {
 return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }

	  
   }
   
     public function update(BaseFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $base=Base::findOrFail($id);
	   $base->valorbase=$request->get('base');
	   $base->update();
	   return Redirect::to('peticion/base')->with('mensaje','La base ha sido actualizada');

                                     }   
			   Else
{
 return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
		   
		   
		   }
		   else
		   {
 return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }

	   
   }
   
   
}
