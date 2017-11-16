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
class Pdf_NotaCreditoController extends Controller
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
			   ->where('p.idrecurso','=',11)
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
		$nota=DB::table('notacredito as n')
			->join('clientes as c','c.idcliente','=','n.idcliente')
			->join('usuarios as u','u.idusuario','=','n.idusuario')
			->select('n.fecha','c.nombrecliente','c.apellidocliente','u.user','n.idnotacredito','n.valornotacredito','n.estado','u.nombreusuario','u.apellidousuario','n.observaciones')
			->where('n.idnotacredito','=',$id)
			->where('n.estado','=','1')
			->get();
			
		$detallenota=DB::table('detallenotacredito as d')
		                  ->join('notacredito as n','d.idnotacredito','=','n.idnotacredito')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','p.idproducto','d.iddetallenotacredito')
		                  ->where('n.idnotacredito','=',$id)
						  ->where('n.estado','=','1')
						  ->get();
		$sumarray=DB::table('detallenotacredito as d')
		                  ->join('notacredito as n','d.idnotacredito','=','n.idnotacredito')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetallenotacredito) as detalle'),DB::raw('sum(d.valor) as val'))
		                  ->where('d.idnotacredito','=',$id)
						  ->where('n.estado','=','1')
						  ->first();
        $view =  \View::make('peticion.pdf.notacredito', compact('infoempresa','nota','detallenota','sumarray'))->render();
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
