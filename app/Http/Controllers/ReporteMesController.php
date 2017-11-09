<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Productos;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use DB;
use Session;
class ReporteMesController extends Controller
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
		
	  $ini=trim($request->get('fecha_ini')." ".'00:00:00');
	  $end=trim($request->get('fecha_end')." ".'23:59:00');
	   //echo $ini; exit;
	  $ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.utilidades','v.descuento','v.comision')
			->whereBetween('v.fecha', array($ini,$end))
			->where('v.estado','=','1')
			->orderby('v.idventa','desc')
			->get();
			$sumarray=DB::table('venta as v')
						  ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),DB::raw('sum(v.descuento) as descuentos'),DB::raw('sum(v.comision) as com'))
						  ->whereBetween('v.fecha', array($ini,$end))
						  ->first();
		$ventausuarios=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'u.user',DB::raw('sum(v.comision) as comision'),DB::raw('sum(v.devolucion) as dev'),DB::raw('sum(v.comision_devolucion) as devcomision'))
								 ->whereBetween('v.fecha', array($ini,$end))
								 ->groupBy('u.idusuario')
								 ->get();
		$tiposventa=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
			                     ->groupBy('t.idtipoventa')
								 ->whereBetween('v.fecha', array($ini,$end))
								 ->get();
		$notacredito=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						 ->whereBetween('n.fecha', array($ini,$end))
						  ->get();
		$sumanota=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->whereBetween('n.fecha', array($ini,$end))
						  ->select(DB::raw('sum(valornotacredito) as valnota'),DB::raw('sum(utilidades) as utilidad'))
						  ->first();
		$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->whereBetween('d.fecha', array($ini,$end))
						  ->get();	
		$devolucionescompras=DB::table('devolucioncompra as d')
						  ->join('proveedor as p','p.idproveedor','=','d.idproveedor')
						  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->join('usuarios as u','u.idusuario','=','c.idusuario')
						  ->whereBetween('c.fecha', array($ini,$end))
						  ->get();	
		 $abonos=DB::table('detalle_abono as da')
						  ->join('convenio as c','c.idconvenio','=','da.idconvenio')
						  ->join('clientes as cl','cl.idcliente','=','da.idcliente')
						  ->whereBetween('da.fecha_abono', array($ini,$end))
						  ->get();
		
		$gasto=DB::table('gasto')
		                  ->whereBetween('fecha', array($ini,$end))
						  ->get();
	     $sumagasto=DB::table('gasto')
			                ->select(DB::raw('sum(valorgasto) as gasto'))
		                    ->whereBetween('fecha', array($ini,$end))
							->first();
		$ingreso=DB::table('otro_ingreso')
		                    ->whereBetween('fecha', array($ini,$end))
							->get();
		$sumaingreso=DB::table('otro_ingreso')
			                ->select(DB::raw('sum(valoringreso) as ingreso'),DB::raw('sum(utilidadingreso) as utilidad'))
		                    ->whereBetween('fecha', array($ini,$end))
							->first();
		$compra=DB::table('compras as c')
			              ->select('idcompra','user','valorcompra')
			              ->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','c.idusuario')
		                   ->whereBetween('c.fecha', array($ini,$end))
						  ->where('c.estado','=','1')
						  ->get();
		$sumacompra=DB::table('compras as c')
			              ->select(DB::raw('sum(c.valorcompra) as valcompra'))
			              ->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','c.idusuario')
		                  ->whereBetween('c.fecha', array($ini,$end))
						  ->where('c.estado','=','1')
						  ->first();
						  $convenios=DB::table('venta as v')
						  ->join('usuarios as u','u.idusuario','=','v.idusuario')
						   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
						   ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
						   ->whereBetween('v.fecha', array($ini,$end))
						   ->where('v.idtipoventa','=',5)
						   ->first();	
						   $sumadev=DB::table('devolucionescliente as d')
						   ->join('clientes as c','c.idcliente','=','d.idcliente')
						   ->join('usuarios as u','u.idusuario','=','d.idusuario')
						   ->join('venta as v','v.idventa','=','d.idventa')
						   ->select(DB::raw('sum(d.valordevolucion) as devolucion'), DB::raw('sum(d.utilidades) as utilidadsuma'),DB::raw('sum(d.subtotal) as subdev'),DB::raw('sum(d.comision) as com_dev'))
						   ->whereBetween('d.fecha', array($ini,$end))
						   ->first();
					  
	return view('peticion.reportemes.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"ventas"=>$ventas,"sumarray"=>$sumarray,"ventausuarios"=>$ventausuarios,"tiposventa"=>$tiposventa,"devoluciones"=>$devoluciones,"gasto"=>$gasto,"sumagasto"=>$sumagasto,"sumaingreso"=>$sumaingreso,"ingreso"=>$ingreso,"sumadev"=>$sumadev,"notacredito"=>$notacredito,"sumanota"=>$sumanota,"compra"=>$compra,"sumacompra"=>$sumacompra,"devolucionescompras"=>$devolucionescompras,"abonos"=>$abonos,"convenios"=>$convenios,"sumadev"=>$sumadev]);
		
							 
	
		 
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
   
   
   
    
   
     
   
   
   
   
}
