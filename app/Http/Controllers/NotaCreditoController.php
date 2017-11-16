<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\NotaCreditoFormRequest;

use hhfarm\Notacredito;
use hhfarm\DetalleVentas;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class NotaCreditoController extends Controller
{
	
   
	public function index(Request $request)
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
   
   
		   if($permiso->leer==1  )
		   {
   
			if($request)
			{
				$clientes=DB::table('clientes')->get();
				$ultimanota=DB::table('notacredito as n')
							  ->where('n.idusuario','=',$request->session()->get('id'))
							  ->orderby('n.idnotacredito','desc')
							  ->select('n.idnotacredito','n.estado')
							  ->first();
			   // $date = Carbon::now();
				//$date = $date->format('Y-m-d');						  
				$query=trim($request->get('searchText'));
				$nota=DB::table('notacredito as n')
				->join('clientes as c','c.idcliente','=','n.idcliente')
				->join('usuarios as u','u.idusuario','=','n.idusuario')
				->select('n.fecha','n.estado','n.idnotacredito','n.idusuario','n.estado','c.nombrecliente','n.valornotacredito','u.user','n.observaciones')
				->where('n.idusuario','=',$request->session()->get('id'))
				->orderby('n.idnotacredito','desc')
				->get();
				return view('peticion.notascredito.index',["nota"=>$nota,"searchText"=>$query,"ultimanota"=>$ultimanota,"clientes"=>$clientes]);
				
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
	public function create(Request $request)
	
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
   
   
		   if($permiso->crear==1 )
		   {
   
			$ultimanota=DB::table('notacredito as n ')
			->where('n.idusuario','=',$request->session()->get('id'))
			->orderby('n.idnotacredito','desc')
			->select('n.idnotacredito','n.estado')
			->first();
			if($ultimanota->estado=="1")
			{
				return Redirect::to('peticion/notascredito');
				
			}
			else{
			
			/*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
$detallenota=DB::table('detallenotacredito as d')
			->join('notacredito as n','d.idnotacredito','=','n.idnotacredito')
			->join('producto as p','d.idproducto','=','p.idproducto')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select('p.codigobarra1','p.descripcionproducto','pr.nombreproveedor','d.cantidad','d.valor','d.iddetallenotacredito')
			->where('d.idnotacredito','=',$ultimanota->idnotacredito)
			->get();
$sumarray=DB::table('detallenotacredito as d')
			->join('notacredito as v','d.idnotacredito','=','v.idnotacredito')
			->join('producto as p','d.idproducto','=','p.idproducto')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select(DB::raw('sum(d.cantidad) as cant'),DB::raw('count(d.iddetallenotacredito) as detalle'),(DB::raw('sum(d.valor) as val')),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidades) as utilidad'))
			->where('d.idnotacredito','=',$ultimanota->idnotacredito)
			->first();

			
			
			
$query=trim($request->get('p'));
$clientes=DB::table('clientes')->get();
$articulos = DB::table('producto as a')
			  ->join('iva as i','a.idiva','=','i.idiva')
			  ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
			  ->join('categoria as c','a.idcategoria','=','c.idcategoria')
			  ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
			  ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
			  ->where('a.idproducto','=',$query)
			  ->get();
$pro= DB::table('producto as a')
			  ->join('iva as i','a.idiva','=','i.idiva')
			  ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
			  ->join('categoria as c','a.idcategoria','=','c.idcategoria')
			  ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
			  ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
			  ->get();
	  return view("peticion.notascredito.create",["clientes"=>$clientes,"articulos"=>$articulos,"ultimanota"=>$ultimanota,"detallenota"=>$detallenota,"sumarray"=>$sumarray,"pro"=>$pro]);
			  
	  
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
	public function store(Request $request)
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
   
   
		   if($permiso->crear==1  )
		   {
   
			if($request->get('ultimanota')==0)
			{
				return Redirect::to('peticion/notascredito');
			}
			else
			{
				 $notacredito=new Notacredito;
				 $notacredito->idcliente='1';
				 $notacredito->valornotacredito='0';
				 $notacredito->subtotal='0';
				 $notacredito->utilidades='0';
				 $mytime= Carbon::now('America/Bogota');
				 $notacredito->fecha=$mytime->toDateTimeString();
				 $notacredito->observaciones='__';
				 $notacredito->idusuario=$request->get('usuario');
				 $notacredito->estado='0';
				 $notacredito->save();
			  return Redirect::to('peticion/notascredito/create');
			  
			  
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
   
   
		   if($permiso->leer==1  )
		   {
   
			$infoempresa=DB::table('infoempresa')
			->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
			->first();
		$nota=DB::table('notacredito as n')
			->join('clientes as c','c.idcliente','=','n.idcliente')
			->join('usuarios as u','u.idusuario','=','n.idusuario')
			->select('n.fecha','c.nombrecliente','c.apellidocliente','u.user','n.idnotacredito','n.valornotacredito','n.estado','n.observaciones','u.nombreusuario','u.apellidousuario','c.nombrecliente','c.apellidocliente')
			->where('n.idnotacredito','=',$id)
			->where('n.estado','=','1')
			->first();
			
		$detallenota=DB::table('detallenotacredito as d')
		                  ->join('notacredito as n','d.idnotacredito','=','n.idnotacredito')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','p.idproducto','d.iddetallenotacredito')
		                  ->where('d.idnotacredito','=',$id)
						  ->where('n.estado','=','1')
						  ->get();
		$sumarray=DB::table('detallenotacredito as d')
		                  ->join('notacredito as n','d.idnotacredito','=','n.idnotacredito')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(d.cantidad) as cant'),DB::raw('count(d.iddetallenotacredito) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'))
		                  ->where('d.idnotacredito','=',$id)
						  ->where('n.estado','=','1')
						  ->first();
			return view("peticion.notascredito.show",["nota"=>$nota,"sumarray"=>$sumarray,"detallenota"=>$detallenota]);
   
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
	 public function update(NotaCreditoFormRequest $request,$id)
	 
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
   
   
		   if($permiso->crear==1)
		   {
   
			$ventas=DB::table('notacredito as n')
			->join('detallenotacredito as d','d.idnotacredito','=','n.idnotacredito')
			->select('n.idnotacredito')
			->where('n.idnotacredito','=',$id)
			->first();
			
			if(sizeof($ventas)==0)
			{
				return Redirect::to('peticion/notascredito/create')->with('mensaje2','No hay productos en la nota credito.')
				                                              ->with('observacion',$request->get('observacion'))
															  ->with('cliente',$request->get('cliente'));
															 
			}
	   else{
		  
															
		  
       $notacredito=Notacredito::findOrFail($id);
	   $notacredito->idcliente=$request->get('cliente');
	   $notacredito->valornotacredito=$request->get('valorventa');
	   $notacredito->subtotal=$request->get('subtotal');
	   $notacredito->utilidades=$request->get('utilidad');
	   $mytime=Carbon::now('America/Bogota');
	   $notacredito->fecha=$mytime->toDateTimeString();
	   $notacredito->observaciones=$request->get('observacion');
	   $notacredito->estado='1';
	   $notacredito->update();
	   return Redirect::to('peticion/notascredito/')->with('mensaje','Nota credito creada correctamente!!.');
   
	
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
