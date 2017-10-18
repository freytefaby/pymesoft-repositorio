<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Gasto;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\GastoFormRequest;
use DB;
use Session;
use Carbon\Carbon;
class GastoController extends Controller
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
		$query=trim($request->get('searchText'));
		                                 $gasto=DB::table('gasto')
		                                 ->where('fecha','LIKE','%'.$query.'%')
										 ->paginate(7);
										 
										 return view('peticion.gasto.index',["gasto"=>$gasto,"searchText"=>$query]);
		 
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
	 return view("peticion.gasto.create");
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
     public function store(GastoFormRequest $request)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $gasto=new Gasto;
	   $mytime= Carbon::now('America/Bogota');
	   $gasto->fecha=$mytime->toDateTimeString();
	   $gasto->descripciongasto=$request->get('descripcion');
	   $gasto->proveedorgasto=$request->get('proveedor');
	   $gasto->valorgasto=$request->get('valor');
	   $gasto->estado='0';
	   $gasto->save();
	   return Redirect::to('peticion/gasto')->with('mensaje','Gasto ingresado correctamente');

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
		$validargasto=DB::table('gasto')
								 ->where('estado','=','1')
								 ->where('idgasto','=',$id)
								 ->first();
		if(sizeof($validargasto)<>0)
		{
			return redirect::to('peticion/gasto'); 
		}

 return view("peticion.gasto.edit",["gasto"=>Gasto::findOrFail($id)]);  

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
   
     public function update(GastoFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $gasto=Gasto::findOrFail($id);
	   $gasto->descripciongasto=$request->get('descripcion');
	   $gasto->proveedorgasto=$request->get('proveedor');
	   $gasto->valorgasto=$request->get('valor');
	   $gasto->update();
	   return Redirect::to('peticion/gasto')->with('mensaje','Gasto fue actualizado correctamente');

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
