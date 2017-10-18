<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Ingreso;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\IngresoFormRequest;
use DB;
use Session;
use Carbon\Carbon;
class IngresoController extends Controller
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
		$query=trim($request->get('p'));
		                                 $ingreso=DB::table('otro_ingreso')
		                                 ->where('fecha','LIKE','%'.$query.'%')
										 ->paginate(7);
										 
										 return view('peticion.ingreso.index',["ingreso"=>$ingreso,"searchText"=>$query]);
		 
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
     public function create(Request $request)
   {
	   if($request->session()->has('id'))
	
     {
	    if($request->session()->get('perfil')==1  )
		{		   
	 return view("peticion.ingreso.create");
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
     public function store(IngresoFormRequest $request)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $ingreso=new Ingreso;
	   $mytime= Carbon::now('America/Bogota');
	   $ingreso->fecha=$mytime->toDateTimeString();
	   $ingreso->descripcioningreso=$request->get('descripcion');
	   $ingreso->proveedoringreso=$request->get('proveedor');
	   $ingreso->valoringreso=$request->get('valor');
	   $ingreso->utilidadingreso=$request->get('utilidad');
	   $ingreso->estado='0';
	   $ingreso->save();
	   return Redirect::to('peticion/ingreso')->with('mensaje','Ingreso ingresado correctamente');

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
		$validargasto=DB::table('otro_ingreso')
								 ->where('estado','=','1')
								 ->where('idingreso','=',$id)
								 ->first();
		if(sizeof($validargasto)<>0)
		{
			return redirect::to('peticion/ingreso'); 
		}

 return view("peticion.ingreso.edit",["ingreso"=>Ingreso::findOrFail($id)]);  

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
   
     public function update(IngresoFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $ingreso=Ingreso::findOrFail($id);
	   $ingreso->descripcioningreso=$request->get('descripcion');
	   $ingreso->proveedoringreso=$request->get('proveedor');
	   $ingreso->valoringreso=$request->get('valor');
	   $ingreso->utilidadingreso=$request->get('utilidad');
	   $ingreso->update();
	   return Redirect::to('peticion/ingreso')->with('mensaje','Ingreso fue actualizado correctamente');

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
