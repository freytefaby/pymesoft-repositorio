<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Categoria;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use DB;
use Session;
class ErrorController extends Controller
{
   public function __construct()
   {
	   
   }
   public function show()
   {
	 return view("peticion.error.error500")->with('mensaje','No tiene permisos necesarios para acceder a este contenido, ingresa como administrador');
	 
   }
    

}
