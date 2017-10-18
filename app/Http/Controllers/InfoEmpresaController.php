<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\InfoEmpresa;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\InfoEmpresaFormRequest;
use DB;
use Session;
class InfoEmpresaController extends Controller
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
		 $empresa=DB::table('infoempresa')->get();
										
	 return view('peticion.infoempresa.index',["empresa"=>$empresa]);
		 
	 }		 

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
   
   
   
   
   
     public function edit(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

return view("peticion.infoempresa.edit",["empresa"=>InfoEmpresa::findOrFail($id)]);  


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
   
     public function update(InfoEmpresaFormRequest $request,$id)
	 
   {
	 if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$empresa=InfoEmpresa::findOrFail($id);
	   $empresa->telefonoempresa=$request->get('telefonoempresa');
	   $empresa->direccionempresa=$request->get('direccionempresa');
	   $empresa->nombrepropietario=$request->get('nombrepropietario');
	   $empresa->apellidopropietario=$request->get('apellidopropietario');
	   $empresa->telefonopropietario=$request->get('telefonopropietario');
	   $empresa->nitempresa=$request->get('nitempresa');
	   $empresa->nombrecomercialempresa=$request->get('nombrecomercialempresa');
	   $empresa->ciudadempresa=$request->get('ciudadempresa');
	   $empresa->update();
	   return Redirect::to('peticion/infoempresa')->with('mensaje','Los datos de la empresa han sido modificados correctamente');

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
   
     public function destroy(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

 $categoria=Categoria::findOrFail($id);
     $categoria->estado='0';
	 $categoria->update();
	 return Redirect::to('peticion/categoria');

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
