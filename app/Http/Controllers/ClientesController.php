<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Clientes;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\ClientesFormRequest;
use DB;
use Session;
class ClientesController extends Controller
{
   public function __construct()
   {
	   
   }
   public function index(Request $request)
   {
	   
	 if($request->session()->has('id'))
	 {
	   
		   
			   if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2   )
			   {
			   
			   
			 if($request)
	 {
		$query=trim($request->get('searchText'));
		                                  $clientes=DB::table('clientes')
		                                 ->where('nombrecliente','LIKE','%'.$query.'%')
		                                 ->orwhere('apellidocliente','LIKE','%'.$query.'%')
										 ->orwhere('cedulacliente','LIKE','%'.$query.'%')
										 ->orwhere('telefonocliente','LIKE','%'.$query.'%')
										 ->orderby('idcliente','nombrecliente')
										 ->paginate(7);
										 
										 return view('peticion.clientes.index',["clientes"=>$clientes,"searchText"=>$query]);
		 
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
	 return view("peticion.clientes.create");
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
     public function store(ClientesFormRequest $request)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$clientes=new Clientes;
	   $clientes->nombrecliente=$request->get('nombre');
	   $clientes->apellidocliente=$request->get('apellido');
	   $clientes->direccioncliente=$request->get('direccion');
	   $clientes->telefonocliente=$request->get('telefono');
	   $clientes->cedulacliente=$request->get('cedula');
	   $clientes->save();
	   return Redirect::to('peticion/clientes');

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
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {

 return view("peticion.clientes.edit",["clientes"=>Clientes::findOrFail($id)]); 

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
   
     public function update(ClientesFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2 )
			   {

       $cliente=Clientes::findOrFail($id);
	   $cliente->nombrecliente=$request->get('nombre');
	   $cliente->apellidocliente=$request->get('apellido');
	   $cliente->direccioncliente=$request->get('direccion');
	   $cliente->telefonocliente=$request->get('telefono');
	   $cliente->cedulacliente=$request->get('cedula');
	   $cliente->update();
	   return Redirect::to('peticion/clientes')->with('mensaje','El cliente fue actualizado correctamente.');

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
