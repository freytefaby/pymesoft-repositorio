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
class Pdf_DevolucionesController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function show(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$infoempresa=DB::table('infoempresa')
			->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
			->first();
	 
  $pro= DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->join('detalleventa as d','d.idproducto','=','a.idproducto')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
							->where('a.estado','=','1')
							->where('d.idventa','=',$id)
							->get();
    
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','u.idusuario','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','u.nombreusuario','u.apellidousuario','c.nombrecliente','c.apellidocliente','c.idcliente')
			->where('v.idventa','=',$id)
			->where('v.estado','=','1')
			->first();
			
		
		
		$detalledevolucion=DB::table('detalledevolucioncliente as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalledevolucioncliente')
		                  ->where('d.iddevolucion','=',$id)
						  ->get();
		$observacion=DB::table('devolucionescliente')
		                 ->where('idventa','=',$id)
						 ->first();
		$sumarraydev=DB::table('detalledevolucioncliente as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalledevolucioncliente) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'))
		                  ->where('d.iddevolucion','=',$id)
						  ->first();
		$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->where('d.idventa','=',$id)
						  ->first();

 
        $view =  \View::make('peticion.pdf.devolucioncliente', compact('infoempresa','ventas','detalledevolucion','observacion','sumarraydev','devoluciones'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

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
