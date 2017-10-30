<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Cupo;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CupoFormRequest;
use hhfarm\Http\Requests\CupoFormRequestCreate;
use DB;
use Session;
use Carbon\Carbon;
class CupoController extends Controller
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
		
        $cupo=DB::table('cupo as cu')
        ->join('clientes as c','c.idcliente','=','cu.idcliente')
        ->get();
        
        
	return view('peticion.cupo.index',["cupo"=>$cupo]);
		 
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
	 return view("peticion.cupo.create");
		} 
                     else

                            {
			
	     return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
				   
			  
                           }
                           }
                    else
                         {

                        //  return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
                             }

	   
	  
	   
   }
     public function store(CupoFormRequestCreate $request)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

	   //return Redirect::to('peticion/gasto')->with('mensaje','Gasto ingresado correctamente');

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
		
				$cupo=DB::table('cupo as cu')
				->join('clientes as c','c.idcliente','=','cu.idcliente')
				->where('cu.idconvenio','=',$id)
				->first();
				return view('peticion.cupo.edit',["cupo"=>$cupo]);		
// return view("peticion.gasto.edit",["gasto"=>Gasto::findOrFail($id)]);  

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
   
     public function update(CupoFormRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {
				$valcupo=DB::table('cupo as cu')
				->join('clientes as c','c.idcliente','=','cu.idcliente')
				->where('cu.idconvenio','=',$id)
				->first();
				$cupo=Cupo::findOrFail($id);
				$cupo->max_credito=$request->get('valor');
				$cupo->dias_credito=$request->get('dias');
				$cupo->update();
	   return Redirect::to('peticion/cupo')->with('mensaje','El usuario'.' '.$valcupo->nombrecliente.' '.$valcupo->apellidocliente.' '.'Se han modificado los siguientes valores <br> Valor del cupo:'.' '.number_format($request->get('valor')).'<br>'.'Dias de credito:'.' '.$request->get('dias'));

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
