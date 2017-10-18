<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Iva;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\IvaFormRequest;
use DB;
use Session;
class IvaController extends Controller
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
		$iva=DB::table('iva')->get();
return view('peticion.iva.index',["iva"=>$iva]);
		 
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
     public function create(Request $request)
   {
	 if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

 return view("peticion.iva.create");

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
     public function store(IvaFormRequest $request)
   {
	 if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

       $iva=new Iva;
	   $iva->valoriva=$request->get('iva');
	   $iva->save();
	   return Redirect::to('peticion/iva');

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
