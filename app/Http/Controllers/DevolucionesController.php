<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;
use hhfarm\Http\Requests\DetalledevolucionFormRequest;

use hhfarm\Ventas;
use hhfarm\Devoluciones;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class DevolucionesController extends Controller
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
			$clientes=DB::table('clientes')->get();
			$ultimaventa=DB::table('venta as v')
			              ->where('v.idusuario','=',$request->session()->get('id'))
						  ->orderby('v.idventa','desc')
						  ->select('v.idventa','v.estado')
						  ->first();
           // $date = Carbon::now();
            //$date = $date->format('Y-m-d');						  
			$query=trim($request->get('searchText'));
			$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.descuento')
			->where(DB::raw('concat("HHF-00",v.idtipoventa,v.idventa)'),'=',$query)
		    ->orderby('v.idventa','desc')
			->get();
			
			$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->get();
			                 
			return view('peticion.devoluciones.index',["ventas"=>$ventas,"searchText"=>$query,"ultimaventa"=>$ultimaventa,"clientes"=>$clientes,"devoluciones"=>$devoluciones]);
			
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

$comp=DB::table('detalledevolucioncliente as d')
		                  ->where('d.iddevolucion','=',$request->get('idventa'))
						  ->first();
						  
		if(sizeof($comp)==0)
		{
			return Redirect::to('peticion/devoluciones/'.$request->get('idventa'))->with('mensaje','No hay productos en el detalle de devolución');
			
		}
else
{

	   $dev=new Devoluciones;
	   $dev->valordevolucion=$request->get('valorventa');
	   $dev->idusuario=$request->get('usuario');
	   $dev->idcliente=$request->get('cliente');
	   $dev->subtotal=$request->get('subtotal');
	   $dev->utilidades=$request->get('utilidad');
	   $dev->idventa=$request->get('idventa');
	   $mytime= Carbon::now('America/Bogota');
	   $dev->fecha=$mytime->toDateTimeString();
	   $dev->estado='1';
	   $dev->observacion=$request->get('observacion');
	   $dev->comision=$request->get('comision');
	   $dev->save();
	   
	   
	   $venta=Ventas::findOrFail($request->get('idventa'));
	   $venta->devolucion=$request->get('valorventa');
	   $venta->comision_devolucion=$request->get('comision');
	   $venta->utilidades_devolucion=$request->get('utilidad');
	   $venta->update();
	return Redirect::to('peticion/devoluciones')->with('mensaje1','Devolución ingresada correctamente');
	
	

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

$vali=DB::table('venta as v')
		          ->join('devolucionescliente as d','d.idventa','=','v.idventa')
				  ->where('d.idventa','=',$id)
				  ->get();
				  
		if(sizeof($vali)<>0)
		{
			return Redirect::to('peticion/devoluciones')->with('mensaje','Esta venta ya se encuentra con una devolucion realizada.');
		}
		else
		{
		
		$query=trim($request->get('p'));
		$articulos = DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->join('detalleventa as d','d.idproducto','=','a.idproducto')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra','d.cantidad','a.comision')
							->where('a.idproducto','=',$query)
							->where('d.idventa','=',$id)
							->get();
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
			
		$detalleventa=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalleventa')
		                  ->where('d.idventa','=',$id)
						  ->where('v.estado','=','1')
						  ->get();
		$sumarray=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalleventa) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'))
		                  ->where('d.idventa','=',$id)
						  ->where('v.estado','=','1')
						  ->first();
		$detalledevolucion=DB::table('detalledevolucioncliente as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalledevolucioncliente')
		                  ->where('d.iddevolucion','=',$id)
						  ->get();
		$sumarraydev=DB::table('detalledevolucioncliente as d')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalledevolucioncliente) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'),DB::raw('sum(d.comision) as comision'))
		                  ->where('d.iddevolucion','=',$id)
						  ->first();
		              
			return view("peticion.devoluciones.show",["ventas"=>$ventas,"sumarray"=>$sumarray,"detalleventa"=>$detalleventa,"pro"=>$pro,"articulos"=>$articulos,"id"=>$id,"detalledevolucion"=>$detalledevolucion,"sumarraydev"=>$sumarraydev]);

      
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
		              
			return view("peticion.devoluciones.view",["ventas"=>$ventas,"pro"=>$pro,"id"=>$id,"detalledevolucion"=>$detalledevolucion,"sumarraydev"=>$sumarraydev,"observacion"=>$observacion]);

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
