<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Ingreso;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\IngresoFormRequest;
use DB;
use Session;
use Carbon\Carbon;
class GraficosController extends Controller
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
		   ->where('p.idrecurso','=',13)
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
		 $ini=trim($request->get('mes'));
		 $anio=trim($request->get('anio'));
		
					 
					 
							   $productos=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('count(d.cantidad) as cant'),'p.descripcionproducto')
							   ->groupby('p.idproducto')
							   ->orderby('cant','desc')
							   ->whereMonth('v.fecha', '=', $ini)
							   ->whereYear('v.fecha', '=', $anio)
							   ->limit(10)
							   ->get();
							   
							   $ventas=DB::table('cierre_diario as c')
							   ->join('usuarios as u','u.idusuario','=','c.idusuario')
							   ->select('c.fecha','c.estado','c.idcierrediario','u.idusuario','c.valorventa','c.subtotal','c.gastos','c.base','c.recogida','c.fechacierre','c.utilidades','u.user')
							   ->orderby('c.fechacierre','asc')
							   ->where('c.estado','=','1')
							   ->whereMonth('c.fechacierre', '=', $ini)
							   ->whereYear('c.fechacierre', '=', $anio)
							   ->get();
							   $sumaventas=DB::table('cierre_diario as c')
							   ->join('usuarios as u','u.idusuario','=','c.idusuario')
							   ->select(DB::raw('sum(recogida) as total'),DB::raw('count(c.idcierrediario) as totaldias'),'c.fecha','c.estado','c.idcierrediario','u.idusuario','c.valorventa','c.subtotal','c.gastos','c.base','c.recogida','c.fechacierre','c.utilidades','u.user')
							   ->where('c.estado','=','1')
							   ->whereMonth('c.fechacierre', '=', $ini)
							   ->whereYear('c.fechacierre', '=', $anio)
							   ->first();
							   $cantidad=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('sum(d.cantidad) as cant'),'p.descripcionproducto')
							   ->groupby('p.idproducto')
							   ->orderby('cant','desc')
							   ->whereMonth('v.fecha', '=', $ini)
							   ->whereYear('v.fecha', '=', $anio)
							   ->limit(10)
							   ->get();
							   $ventasusuarios=DB::table('venta as v')
								   ->join('usuarios as u','u.idusuario','=','v.idusuario')
								   ->select(DB::raw('sum(v.valorventa) as valor'),'u.user')
								   ->groupby('v.idusuario')
								   ->whereMonth('v.fecha', '=', $ini)
								   ->whereYear('v.fecha', '=', $anio)
								   ->get();
							   $laboratorio=DB::table('detalleventa as d')
							   ->join('venta as v','v.idventa','=','d.idventa')
							   ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
							   ->join('producto as p','p.idproducto','=','d.idproducto')
							   ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
							   ->join('clientes as c','c.idcliente','=','v.idcliente')
							   ->join('usuarios as u','u.idusuario','=','v.idusuario')
							   ->select(DB::raw('count(d.cantidad) as cant'),'p.descripcionproducto','pr.nombreproveedor')
							   ->groupby('p.idproveedor')
							   ->orderby('cant','desc')
							   ->whereMonth('v.fecha', '=', $ini)
							   ->whereYear('v.fecha', '=', $anio)
							   ->limit(10)
							   ->get();
							   
			   
											
		   return view('peticion.graficos.index',["productos"=>$productos,"ventas"=>$ventas,"cantidad"=>$cantidad,"sumaventas"=>$sumaventas,"ventasusuarios"=>$ventasusuarios,"laboratorio"=>$laboratorio,"anio"=>$anio,"ini"=>$ini]);
		   
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
