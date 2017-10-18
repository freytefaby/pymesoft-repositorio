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
class Pdf_CierreDiarioController extends Controller
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
		$exist=DB::table('cierre_diario')
                    ->where('idcierrediario','=',$id)
					->first();
		
			$query=$exist->fechacierre;		
	
	
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.utilidades')
		    ->where('v.fecha','LIKE','%'.$query.'%')
			->where('v.estado','=','1')
			->orderby('v.idventa','desc')
			->get();
			
		 
			
						  /*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
		
		$sumarray=DB::table('venta as v')
						  ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'))
						  ->where('v.fecha','LIKE','%'.$query.'%')
						  ->first();
		
						  
						  
						  
		
		
			$tiposventa=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
			                     ->groupBy('t.idtipoventa')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->get();
			$ventausuarios=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'u.user')
			                     ->groupBy('u.idusuario')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->get();
			$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->where('v.fecha','LIKE','%'.$query.'%')
						  ->get();
			 $gasto=DB::table('gasto')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumagasto=DB::table('gasto')
			                ->select(DB::raw('sum(valorgasto) as gasto'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$base=DB::table('base_caja')->first();
			$ingreso=DB::table('otro_ingreso')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumaingreso=DB::table('otro_ingreso')
			                ->select(DB::raw('sum(valoringreso) as ingreso'),DB::raw('sum(utilidadingreso) as utilidad'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$notacredito=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->get();
			$sumanota=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->select(DB::raw('sum(valornotacredito) as valnota'),DB::raw('sum(utilidades) as utilidad'))
						  ->first();
			$compra=DB::table('compras as c')
			              ->select('idcompra','user','valorcompra')
			              ->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','c.idusuario')
		                  ->where('c.fecha','LIKE','%'.$query.'%')
						  ->where('c.estado','=','1')
						  ->get();
        $view =  \View::make('peticion.pdf.cierrediario', compact('infoempresa','exist','ventas','sumarray','tiposventa','ventausuarios','devoluciones','gasto','sumagasto','base','ingreso','sumaingreso','notacredito','sumanota','compra'))->render();
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
