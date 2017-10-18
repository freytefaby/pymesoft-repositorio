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
class Pdf_DevolucionesComprasController extends Controller
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
    
		$compras=DB::table('compras as c')
			->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado','u.idusuario','c.idproveedor')
			->where('c.idcompra','=',$id)
		    ->orderby('c.idcompra','desc')
			->first();
			
		
		
		$detalledevolucion=DB::table('detalledevolucioncompra as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalledevolucioncompra')
		                  ->where('d.idcompra','=',$id)
						  ->get();
		$observacion=DB::table('devolucioncompra')
		                 ->where('idcompra','=',$id)
						 ->first();
		$sumarraydev=DB::table('detalledevolucioncompra as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalledevolucioncompra) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'))
		                  ->where('d.idcompra','=',$id)
						  ->first();
		$devoluciones=DB::table('devolucioncompra as d')
			              ->join('proveedor as p','p.idproveedor','=','d.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->select('d.fecha','p.nombreproveedor','p.nitproveedor','u.user','c.idcompra','d.valordevolucion','d.iddevolucioncompra','d.observacion')
						  ->where('d.idcompra','=',$id)
						  ->first();

 
        $view =  \View::make('peticion.pdf.devolucioncompra', compact('infoempresa','compras','detalledevolucion','observacion','sumarraydev','devoluciones'))->render();
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
