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

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',5)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->leer==1  )
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
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',5)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1  )
		   {
   
			return view("peticion.clientes.create");	   
			
   
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
     public function store(ClientesFormRequest $request)
   {
	  
	
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',5)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1  )
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
   
    
   
     public function edit(Request $request,$id)
   {
	  
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',5)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->modificar==1 )
		   {
   
			return view("peticion.clientes.edit",["clientes"=>Clientes::findOrFail($id)]); 
   
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
   
     public function update(ClientesFormRequest $request,$id)
	 
   {
	  
	
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',5)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->modificar==1  )
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
