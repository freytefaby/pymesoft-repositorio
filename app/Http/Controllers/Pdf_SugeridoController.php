<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;


use hhfarm\Ventas;
use hhfarm\DetalleVentas;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class Pdf_SugeridoController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function ticket(Request $request)
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


	if($permiso->leer==1  )
	{

		$infoempresa=DB::table('infoempresa')
		->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
		->first();
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

	$view =  \View::make('peticion.pdf.sugeridoticket', compact('consulta','infoempresa'))->render();
	$pdf = \App::make('dompdf.wrapper');
	$pdf->loadHTML($view);
	return $pdf->stream('invoice');

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
   
   public function carta(Request $request)
   
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
   
   
		   if($permiso->leer==1  )
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

$infoempresa=DB::table('infoempresa')
->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
->first();

$view =  \View::make('peticion.pdf.sugeridocarta', compact('infoempresa','consulta'))->render();
$pdf = \App::make('dompdf.wrapper');
$pdf->loadHTML($view);
return $pdf->stream('invoice');
   
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
