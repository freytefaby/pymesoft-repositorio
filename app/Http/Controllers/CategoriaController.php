<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Categoria;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use DB;
use Session;
class CategoriaController extends Controller
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
		$categoria=DB::table('categoria')->where('descripcioncategoria','LIKE','%'.$query.'%')
		                                 ->where('estado','=','1')
										 ->orderby('idcategoria','descripcioncategoria')
										 ->paginate(7);
										 
										 return view('peticion.categoria.index',["categoria"=>$categoria,"searchText"=>$query]);
		 
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
	 return view("peticion.categoria.create");
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
     public function store(CategoriaFormRequest $request)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $categoria=new Categoria;
	   $categoria->descripcioncategoria=$request->get('categoria');
	   $categoria->descrip=$request->get('descripcion');
	   $categoria->estado='1';
	   $categoria->save();
	   return Redirect::to('peticion/categoria');

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
   
     public function show(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

 return view("peticion.categoria.show",["categoria"=>Categoria::findOrFail($id)]);  

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

 return view("peticion.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);  

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
   
     public function update(CategoriaFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $categoria=Categoria::findOrFail($id);
	   $categoria->descripcioncategoria=$request->get('categoria');
	   $categoria->descrip=$request->get('descripcion');
	   $categoria->update();
	   return Redirect::to('peticion/categoria')->with('mensaje','Categoria fue actualizada correctamente.');

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
