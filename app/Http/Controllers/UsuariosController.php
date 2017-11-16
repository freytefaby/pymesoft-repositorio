<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Usuarios;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use hhfarm\Http\Requests\UsuariosFormRequest;
use hhfarm\Http\Requests\UsuariosUpdateFormRequest;
use hhfarm\Http\Requests\ContrasenaUpdateFormRequest;
use DB;
use Session;
class UsuariosController extends Controller
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
		   ->where('p.idrecurso','=',24)
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
										   $usuarios=DB::table('usuarios as u')
										   ->join('perfil as p','p.idperfil','=','u.idperfil')
										   ->where('nombreusuario','LIKE','%'.$query.'%')
										   ->orwhere('apellidousuario','LIKE','%'.$query.'%')
										   ->orwhere('cedulausuario','LIKE','%'.$query.'%')
										   ->orwhere('user','LIKE','%'.$query.'%')
											->where('estado','=','1')
											->orderby('idusuario','asc')
											->paginate(7);
											
											return view('peticion.usuarios.index',["usuarios"=>$usuarios,"searchText"=>$query]);
			
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
		   ->where('p.idrecurso','=',24)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1  )
	   {

		$perfiles=DB::table('perfil')->get();
		
return view("peticion.usuarios.create",["perfiles"=>$perfiles]);

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
     public function store(UsuariosFormRequest $request)
   {
	  
	
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',24)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1 )
		   {
   
			if($request->get('contrasena2')<>$request->get('contrasena') or $request->get('contrasena')<>$request->get('contrasena2') )
			{
				
				return Redirect::to('peticion/usuarios/create')->with('mensaje','Contraseñas son incorrectas')
																 ->with('nombre',$request->get('nombre'))
																 ->with('apellido',$request->get('apellido'))
																 ->with('perfiles',$request->get('perfiles'))
																 ->with('telefono',$request->get('telefono'))
																 ->with('cedula',$request->get('cedula'))
																 ->with('usuario',$request->get('usuario'));
																 
			}
			$usuario=new Usuarios;
			$usuario->idperfil=$request->get('perfiles');
			$usuario->nombreusuario=$request->get('nombre');
			$usuario->apellidousuario=$request->get('apellido');
			$usuario->telefonousuario=$request->get('telefono');
			$usuario->cedulausuario=$request->get('cedula');
			$usuario->cuotausuario='0';
			$usuario->contrasena=sha1($request->get('contrasena'));
			$usuario->user=$request->get('usuario');
			$usuario->estado='1';
			if(Input::hasfile('foto'))
			{
				$file=Input::file('foto');
				$file->move(public_path().'/images/usuarios/',$file->getClientOriginalName() );
				 $usuario->imagen=$file->getClientOriginalName();
			}
		   
		   
			$usuario->save();
			return Redirect::to('peticion/usuarios');
   
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
		->where('p.idrecurso','=',24)
		->first();
if(count($permiso)==0)
{
	return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
}
else
{
	  if($permiso->modificar==1)
			   {

$perfiles=DB::table('perfil')->get();
 return view("peticion.usuarios.edit",["usuarios"=>Usuarios::findOrFail($id),"perfiles"=>$perfiles]);  

                                     }   

									 
			   else
{
	if($request->session()->get('id')==$id)
	{
        $perfiles=DB::table('perfil')->get();
        return view("peticion.usuarios.edit",["usuarios"=>Usuarios::findOrFail($id),"perfiles"=>$perfiles]);
		
	}
	else{
 return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
			   }
			   


			   }
		   
		   
		   }
		   else
		   {
 return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }



                                      
		
		   
		   
		

	  
   }
  
     public function update(UsuariosUpdateFormRequest $request,$id)
	 
   {
	 
 if($request->session()->has('id'))
	 {
		$permiso=DB::table('permiso as p')
		->where('p.idrol','=',$request->session()->get('perfil'))
		->where('p.idrecurso','=',24)
		->first();
if(count($permiso)==0)
{
	return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
}else

{
  if($permiso->modificar==1  )
			   {

       $usuario=Usuarios::findOrFail($id);
	   $usuario->idperfil=$request->get('perfiles');
	   $usuario->nombreusuario=$request->get('nombre');
	   $usuario->apellidousuario=$request->get('apellido');
	   $usuario->telefonousuario=$request->get('telefono');
	   $usuario->cedulausuario=$request->get('cedula');
	   $usuario->cuotausuario='0';
	   $usuario->user=$request->get('usuario');
	   $usuario->estado='1';
	   if(Input::hasfile('foto'))
	   {
		   $file=Input::file('foto');
		   $file->move(public_path().'/images/usuarios/',$file->getClientOriginalName() );
		   $usuario->imagen=$file->getClientOriginalName();
	   }
	   else
	   {
		   
		   $usuario->imagen=$request->get('img');
	   }
	  
	   $usuario->update();
	   return Redirect::to('peticion/usuarios')->with('mensaje','Usuario actualizado correctamente');

                                     }    
			   else
{
	if($request->session()->get('id')==$id)
	{
		$usuario=Usuarios::findOrFail($id);
	   $usuario->idperfil=$request->get('perfiles');
	   $usuario->nombreusuario=$request->get('nombre');
	   $usuario->apellidousuario=$request->get('apellido');
	   $usuario->telefonousuario=$request->get('telefono');
	   $usuario->cedulausuario=$request->get('cedula');
	   $usuario->cuotausuario='0';
	   $usuario->user=$request->get('usuario');
	   $usuario->estado='1';
	   if(Input::hasfile('foto'))
	   {
		   $file=Input::file('foto');
		   $file->move(public_path().'/images/usuarios/',$file->getClientOriginalName() );
		   $usuario->imagen=$file->getClientOriginalName();
	   }
	   else
	   {
		   
		   $usuario->imagen=$request->get('img');
	   }
	  
	   $usuario->update();
	   $request->session()->flush();
	  return Redirect::to('peticion/login');
		
		}else
		{
	
	
	
 return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
			   }
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

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',24)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->eliminar==1  )
	   {

		$usuario=Usuarios::findOrFail($id);
		$usuario->estado='0';
		$usuario->update();
		return Redirect::to('peticion/usuarios');

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
   
   public function restablecer(Request $request,$id)
   {
	
	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',24)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->modificar==1)
	   {

		return view("peticion.usuarios.contrasena",["usuarios"=>Usuarios::findOrFail($id)]);  

							 }   
	   else
{
	if($request->session()->get('id')==$id)
	{
		return view("peticion.usuarios.contrasena",["usuarios"=>Usuarios::findOrFail($id)]); 
		
	}else
	{
		return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido perfiles, ingresa como administrador');
	
	}

		   
	   }

	  






	   
   }

	  
 
		  
		  
		  }
		  else
		  {
return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		  }

	   

	

		   
		

	 
 
	  
   }
    
    public function updatecontrasena(ContrasenaUpdateFormRequest $request,$id)
   {

	   if($request->session()->has('id'))
	 {
		$permiso=DB::table('permiso as p')
		->where('p.idrol','=',$request->session()->get('perfil'))
		->where('p.idrecurso','=',24)
		->first();
if(count($permiso)==0)
{
	return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
}else

{
  if($permiso->modificar==1 )
			   {

				if($request->get('confirmar')<>$request->get('contrasena') or $request->get('contrasena')<>$request->get('confirmar') )
				{
					
				   return Redirect::to('peticion/restablecer/'.$id)->with('mensaje','Las credenciales son incorrectas');
																	 
				}
				$usuario=Usuarios::findOrFail($id);
				$usuario->contrasena=sha1($request->get('contrasena'));
				$usuario->update();
				return Redirect::to('peticion/usuarios')->with('mensaje','Usuario actualizado correctamente, debes cerrar sesion para que los cambios puedan efectuarse');

                                     }   
			  else
{
	
	if($request->session()->get('id')==$id)
	{
		if($request->get('confirmar')<>$request->get('contrasena') or $request->get('contrasena')<>$request->get('confirmar') )
	   {
		   
		  return Redirect::to('peticion/restablecer/'.$id)->with('mensaje','Las credenciales son incorrectas');
															
	   }
	   $usuario=Usuarios::findOrFail($id);
	   $usuario->contrasena=sha1($request->get('contrasena'));
	   $usuario->update();
	   $request->session()->flush();
	  return Redirect::to('peticion/login');
	  
	}
	else
	{
 return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			   }
			   }
			   

			   }
		   
		   
		   }
		   else
		   {
 return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }

	   
	  
   }
   
}
