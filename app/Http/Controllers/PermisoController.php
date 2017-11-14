<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Permiso;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\RecursoFormRequest;
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
		
    $permisos=DB::table('perfil as p')
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
	$permiso=DB::table('permiso as p')
	->join('recurso as r','r.idrecurso','=','p.idrecurso')
	->join('perfil as pe','pe.idperfil','=','p.idrol')
	->where('p.idrol','=',$id)
	->get();

	$recursos=DB::table('recurso')
	->get();
 return view("peticion.permiso.update",["permiso"=>$permiso,"id"=>$id,"recursos"=>$recursos]);  

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
   
     public function update(Request $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {
				$cont=0;   //print_r($_POST); EXIT;
				while($cont < count($request->get('recurso')))
				{  
				 DB::update('update permiso set leer =?, crear=?, eliminar=?, modificar = ? where idrecurso = ?',[$request->get('leer')[$cont],$request->get('crear')[$cont],$request->get('eliminar')[$cont],$request->get('modificar')[$cont],$request->get('recurso')[$cont]]);
				 $cont=$cont+1;
					
				}
	   return Redirect::to('peticion/permisos/'.$id.'/edit')->with('mensaje','Permisos modificados');

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






   public function store(RecursoFormRequest $request)
   
 {
	 if($request->session()->has('id'))
   {
	 
if($request->session()->get('perfil')==1  )
			 {
			   // print_r($_POST); EXIT;
				$permiso=DB::table('permiso as p')
				->join('recurso as r','r.idrecurso','=','p.idrecurso')
				->join('perfil as pe','pe.idperfil','=','p.idrol')
				->where('p.idrecurso','=',$request->get('recursos'))
				->where('p.idrol','=',$request->get('perfil'))
				->first();
		if(count($permiso)>0)
		{
			return Redirect::to('peticion/permisos/'.$request->get('perfil').'/edit')->with('mensaje','Este permiso ya existe para este perfil');
			
		}
		else
		{
			$permiso=new Permiso;
			$permiso->idrecurso=$request->get('recursos');
			$permiso->idrol=$request->get('perfil');
			$permiso->crear='0';
			$permiso->leer='0';
			$permiso->modificar='0';
			$permiso->eliminar='0';
			$permiso->save();
			return Redirect::to('peticion/permisos/'.$request->get('perfil').'/edit')->with('mensaje','Permiso creado al perfil');
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
   
   
}
