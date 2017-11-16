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
class Pdf_CompraController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function show(Request $request,$id)
   {
	  
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',6)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->leer==1 )
		   {
   
			$infoempresa=DB::table('infoempresa')
			->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
			->first();
		$compras=DB::table('compras as c')
			->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado','c.subtotalcompra','u.user','p.nombreproveedor')
			->where('c.idcompra','=',$id)
		    ->orderby('c.estado','1')
			->first();
			
		$detallecompra=DB::table('detallecompra as d')
		                  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valorcompra','d.subtotalcompra','p.idproducto','d.iddetallecompra')
		                  ->where('d.idcompra','=',$id)
						  ->where('c.estado','=','1')
						  ->get();
		$sumarray=DB::table('detallecompra as d')
		                  ->join('compras as c','d.idcompra','=','c.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetallecompra) as detalle'),DB::raw('sum(d.valorcompra) as val'),DB::raw('sum(d.subtotalcompra) as sub'),DB::raw('sum(d.utilidadcompra) as utilidad'))
		                  ->where('d.idcompra','=',$id)
						  ->where('c.estado','=','1')
						  ->first();
        $view =  \View::make('peticion.pdf.compra', compact('infoempresa','compras','detallecompra','sumarray'))->render();
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
