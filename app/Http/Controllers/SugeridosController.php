<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Productos;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\ProductosFormRequest;
use hhfarm\Http\Requests\ProductosFormRequestUpdate;
use DB;
use Session;
class SugeridosController extends Controller
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
       ->where('p.idrecurso','=',20)
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
                             
                        
                 $consulta=DB::select('select d.idproducto, count(d.idproducto)as ventas, p.stock, p.stockminimo,p.codigobarra1,p.descripcionproducto,pr.nombreproveedor, sum(p.stockminimo - p.stock) as cant, p.preciocompra,p.cantidadempaque, (p.preciocompra/p.cantidadempaque*(p.stockminimo - p.stock)) as costo  
                                                     from 
                             detalleventa as d, producto as p , proveedor as pr
                                                     where 
                             d.idproducto=p.idproducto 
                             and 
                             pr.idproveedor=p.idproveedor
                             and
                             p.stockminimo > p.stock 
                                                     group by (d.idproducto)
                                                     order by ventas desc');
                
                
                
                //DB::raw('sum((p.preciocompra/p.cantidadempaque) * (p.sugerido) ) as compra')
                
                //select sum(p.preciocompra)as total from producto as p WHERE p.idtipoproducto = 2 and p.stockminimo>p.stock
        return view('peticion.sugerido.index',["consulta"=>$consulta]);
        
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
    
  
   
    
	}
