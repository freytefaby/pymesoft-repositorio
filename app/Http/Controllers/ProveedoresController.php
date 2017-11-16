<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Proveedor;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\ProveedorFormRequest;
use DB;
use Session;
class ProveedoresController extends Controller
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
		   ->where('p.idrecurso','=',23)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->leer==1 )
	   {

		if($request)
		{
		   $query=trim($request->get('searchText'));
		   $proveedor=DB::table('proveedor')->where('nombreproveedor','LIKE','%'.$query.'%')
											->orwhere('nitproveedor','LIKE','%'.$query.'%')
											->orderby('idproveedor','nombreproveedor')
											->paginate(7);
											return view('peticion.proveedor.index',["proveedor"=>$proveedor,"searchText"=>$query]);
			
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
		   ->where('p.idrecurso','=',23)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1 )
	   {

		return view("peticion.proveedor.create");

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
     public function store(ProveedorFormRequest $request)
   {
	 
	  
	
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',23)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1 )
		   {
   
			$proveedor=new Proveedor;
			$proveedor->nombreproveedor=$request->get('proveedor');
			$proveedor->nitproveedor=$request->get('nit');
			$proveedor->nombrepropietarioproveedor=$request->get('representante');
			$proveedor->apellidopropietarioproveedor=$request->get('apellidorepresentante');
			$proveedor->celularproveedor=$request->get('celular');
			$proveedor->direccionproveedor=$request->get('direccion');
			$proveedor->save();
			return Redirect::to('peticion/proveedores');
   
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
		   ->where('p.idrecurso','=',23)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->modificar==1  )
	   {

		return view("peticion.proveedor.edit",["proveedor"=>Proveedor::findOrFail($id)]);

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
   
     public function update(ProveedorFormRequest $request,$id)
	 
   {

	
	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',23)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->modificar==1  )
	   {

		$proveedor=Proveedor::findOrFail($id);
		$proveedor->nombreproveedor=$request->get('proveedor');
		$proveedor->nitproveedor=$request->get('nit');
		$proveedor->nombrepropietarioproveedor=$request->get('representante');
		$proveedor->apellidopropietarioproveedor=$request->get('apellidorepresentante');
		$proveedor->celularproveedor=$request->get('celular');
		$proveedor->direccionproveedor=$request->get('direccion');
		$proveedor->update();
		return Redirect::to('peticion/proveedores')->with('mensaje','Proveedor fue actualizado correctamente.');  

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
