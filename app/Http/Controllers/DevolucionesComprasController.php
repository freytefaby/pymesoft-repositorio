<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;
use hhfarm\Http\Requests\DetalledevolucionFormRequest;

use hhfarm\Ventas;
use hhfarm\DevolucionesCompras;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class DevolucionesComprasController extends Controller
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
			$proveedor=DB::table('proveedor')->get();
			$ultimacompra=DB::table('compras as c')
			              ->where('c.idusuario','=',$request->session()->get('id'))
						  ->orderby('c.idcompra','desc')
						  ->select('c.idcompra','c.estado')
						  ->first();
           // $date = Carbon::now();
            //$date = $date->format('Y-m-d');						  
			$query=trim($request->get('searchText'));
			$compras=DB::table('compras as c')
			->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado','p.idproveedor')
			->where('c.idcompra','=',$query)
		    ->orderby('c.idcompra','desc')
			->get();
			
			$devoluciones=DB::table('devolucioncompra as d')
			              ->join('proveedor as p','p.idproveedor','=','d.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->select('d.fecha','p.nombreproveedor','p.nitproveedor','u.user','c.idcompra','d.valordevolucion','d.iddevolucioncompra','d.observacion')
						  ->get();
			                 
			return view('peticion.devoluciones_compras.index',["compras"=>$compras,"searchText"=>$query,"ultimacompra"=>$ultimacompra,"devoluciones"=>$devoluciones]);
			
		}


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
	
	public function store(DetalleDevolucionFormRequest $request)
	{
		
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$comp=DB::table('detalledevolucioncompra as d')
		                  ->where('d.idcompra','=',$request->get('idcompra'))
						  ->first();
						  
		if(sizeof($comp)==0)
		{
			return Redirect::to('peticion/devolucionescompras/'.$request->get('idcompra'))->with('mensaje','No hay productos en el detalle de devolución');
			
		}
else
{

	   $dev=new DevolucionesCompras;
	   $dev->valordevolucion=$request->get('valorventa');
	   $dev->idusuario=$request->get('usuario');
	   $dev->idproveedor=$request->get('proveedor');
	   $dev->subtotal=$request->get('subtotal');
	   $dev->utilidades=$request->get('utilidad');
	   $dev->idcompra=$request->get('idcompra');
	   $mytime= Carbon::now('America/Bogota');
	   $dev->fecha=$mytime->toDateTimeString();
	   $dev->estado='1';
	   $dev->observacion=$request->get('observacion');
	   $dev->save();
	return Redirect::to('peticion/devolucionescompras')->with('mensaje1','Devolución realizada correctamente.');
	
	

	}

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
	public function show(Request $request,$id)
	{
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$vali=DB::table('compras as c')
		          ->join('devolucioncompra as d','d.idcompra','=','c.idcompra')
				  ->where('c.idcompra','=',$id)
				  ->get();
				  
		if(sizeof($vali)<>0)
		{
			return Redirect::to('peticion/devolucionescompras')->with('mensaje','Esta compra ya se encuentra con una devolucion realizada.');
		}
		else
		{
		
		$query=trim($request->get('p'));
		$articulos = DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->join('detallecompra as d','d.idproducto','=','a.idproducto')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra','d.cantidad')
							->where('a.idproducto','=',$query)
							->where('d.idcompra','=',$id)
							->get();
	$pro= DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->join('detallecompra as d','d.idproducto','=','a.idproducto')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
							->where('a.estado','=','1')
							->where('d.idcompra','=',$id)
							->get();
    
		$compras=DB::table('compras as c')
			->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado','u.idusuario','c.idproveedor')
			->where('c.idcompra','=',$id)
		    ->orderby('c.idcompra','desc')
			->first();
			
		$detallecompra=DB::table('detallecompra as d')
		                  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valorcompra','d.subtotalcompra','p.idproducto','d.iddetallecompra')
		                  ->where('d.idcompra','=',$id)
						  ->get();
		$sumarray=DB::table('detallecompra as d')
		                  ->join('compras as c','d.idcompra','=','c.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetallecompra) as detalle'),DB::raw('sum(d.valorcompra) as val'),DB::raw('sum(d.subtotalcompra) as sub'),DB::raw('sum(d.utilidadcompra) as utilidad'))
		                  ->where('d.idcompra','=',$id)
						  ->first();
		$detalledevolucion=DB::table('detalledevolucioncompra as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalledevolucioncompra')
		                  ->where('d.idcompra','=',$id)
						  ->get();
		$sumarraydev=DB::table('detalledevolucioncompra as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalledevolucioncompra) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'))
		                  ->where('d.idcompra','=',$id)
						  ->first();
		              
			return view("peticion.devoluciones_compras.show",["compras"=>$compras,"sumarray"=>$sumarray,"detallecompra"=>$detallecompra,"pro"=>$pro,"articulos"=>$articulos,"id"=>$id,"detalledevolucion"=>$detalledevolucion,"sumarraydev"=>$sumarraydev]);

      
	  }

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
	public function mostrar(Request $request, $id)
	{
		
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

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
		              
			return view("peticion.devoluciones_compras.view",["compras"=>$compras,"pro"=>$pro,"id"=>$id,"detalledevolucion"=>$detalledevolucion,"sumarraydev"=>$sumarraydev,"observacion"=>$observacion]);

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
