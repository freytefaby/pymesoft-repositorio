<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Productos;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use DB;
use Session;
class MovimientoController extends Controller
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
		   ->where('p.idrecurso','=',18)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->leer==1  )
	   {

		if($request)
		{
		   
		 $ini=trim($request->get('fecha_ini')." ".'00:00:00');
		 $end=trim($request->get('fecha_end')." ".'23:59:00');
		 $tipo=trim($request->get('tipo'));
		 $producto=trim($request->get('p'));
		  //echo $ini; exit;
		  $pro= DB::table('producto as a')
							   ->join('iva as i','a.idiva','=','i.idiva')
							   ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							   ->join('categoria as c','a.idcategoria','=','c.idcategoria')
							   ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							   ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
							   ->where('a.estado','=','1')
							   ->get();
		   $movimiento=DB::table('tiposmovimientos')->get();
	   
		 
			 switch ($tipo)
			 {
				case '1':
				$consulta=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('v.estado','=','1')
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->get();
				$sumarray=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('sum(d.cantidad) as cant'))
							   ->where('p.codigobarra1','=',$producto)
							   ->where('v.estado','=','1')
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->first();
			   
			   return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
				break; 
				case '2':
				$consulta=DB::table('detallecompra as d')
							   ->join('compras as c','c.idcompra','=','d.idcompra')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('proveedor as pr','pr.idproveedor','=','c.idproveedor')
							   ->join('usuarios as u','u.idusuario','=','c.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('c.estado','=','1')
							   ->whereBetween('c.fecha', array($ini,$end))
							   ->get();
				$sumarray=DB::table('detallecompra as d')
							   ->join('compras as c','c.idcompra','=','d.idcompra')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('proveedor as pr','pr.idproveedor','=','c.idproveedor')
							   ->join('usuarios as u','u.idusuario','=','c.idusuario')
							   ->select(DB::raw('sum(d.cantidad) as cant'))
							   ->where('p.codigobarra1','=',$producto)
							   ->where('c.estado','=','1')
							   ->whereBetween('c.fecha', array($ini,$end))
							   ->first();
			   return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
				break;
				case '3':
				 $consulta=DB::table('detalledevolucioncliente as d')
							 ->join('venta as v','v.idventa','=','d.iddevolucion')
							 ->join('devolucionescliente as dc','dc.idventa','=','v.idventa')
							 ->join('producto as p','p.idproducto','=','d.idproducto')
							 ->join('clientes as c','c.idcliente','=','v.idcliente')
							 ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('dc.estado','=','1')
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->get();
				$sumarray=DB::table('detalledevolucioncliente as d')
							 ->join('venta as v','v.idventa','=','d.iddevolucion')
							 ->join('devolucionescliente as dc','dc.idventa','=','v.idventa')
							 ->join('producto as p','p.idproducto','=','d.idproducto')
							 ->join('clientes as c','c.idcliente','=','v.idcliente')
							 ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('sum(d.cantidad) as cant'))
							   ->where('p.codigobarra1','=',$producto)
							   ->where('dc.estado','=','1')
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->first();
			   return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
				break;
				 case '4':
				 $consulta=DB::table('detalledevolucioncompra as d')
							 ->join('compras as c','c.idcompra','=','d.idcompra')
							 ->join('devolucioncompra as dc','dc.idcompra','=','c.idcompra')
							 ->join('producto as p','p.idproducto','=','d.idproducto')
							 ->join('proveedor as pr','pr.idproveedor','=','c.idproveedor')
							 ->join('usuarios as u','u.idusuario','=','c.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('dc.estado','=','1')
							   ->whereBetween('c.fecha', array($ini,$end))
							   ->get();
				$sumarray=DB::table('detalledevolucioncompra as d')
							 ->join('compras as c','c.idcompra','=','d.idcompra')
							 ->join('devolucioncompra as dc','dc.idcompra','=','c.idcompra')
							 ->join('producto as p','p.idproducto','=','d.idproducto')
							 ->join('proveedor as pr','pr.idproveedor','=','c.idproveedor')
							 ->join('usuarios as u','u.idusuario','=','c.idusuario')
							 ->select(DB::raw('sum(d.cantidad) as cant'))
							   ->where('p.codigobarra1','=',$producto)
							   ->where('dc.estado','=','1')
							   ->whereBetween('c.fecha', array($ini,$end))
							   ->first();
			   return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
				break;
				case '5':
				$consulta=DB::table('detallenotacredito as d')
							   ->join('notacredito as n','n.idnotacredito','=','d.idnotacredito')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','n.idcliente')
							   ->join('usuarios as u','u.idusuario','=','n.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('n.estado','=','1')
							   ->whereBetween('n.fecha', array($ini,$end))
							   ->get();
				$sumarray=DB::table('detallenotacredito as d')
								->join('notacredito as n','n.idnotacredito','=','d.idnotacredito')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','n.idcliente')
							   ->join('usuarios as u','u.idusuario','=','n.idusuario')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('n.estado','=','1')
							   ->whereBetween('n.fecha', array($ini,$end))
							   ->first();
			   
			   return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
				break; 
				 
				}
		$consulta=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->where('p.codigobarra1','=',$producto)
							   ->where('p.codigobarra1','=','null')
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->get();
		$sumarray=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('sum(d.cantidad) as cant'))
							   ->where('p.codigobarra1','=',$producto)
							   ->whereBetween('v.fecha', array($ini,$end))
							   ->first();
	   
	   
		return view('peticion.movimiento.index',["ini"=>$request->get('fecha_ini'),"end"=>$request->get('fecha_end'),"pro"=>$pro,"consulta"=>$consulta,"tipo"=>$tipo,"producto"=>$producto,"movimiento"=>$movimiento,"sumarray"=>$sumarray]);
	   
		   
								
	   
			
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
