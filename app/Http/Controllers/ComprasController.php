<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\ComprasForRequest;

use hhfarm\Compras;

use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class ComprasController extends Controller
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
			   ->where('p.idrecurso','=',6)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->leer==1 )
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
				->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado','c.idusuario')
				
				->orderby('c.idcompra','desc')
				
				->get();
				return view('peticion.compras.index',["compras"=>$compras,"searchText"=>$query,"ultimacompra"=>$ultimacompra,"proveedor"=>$proveedor]);
				
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
			   ->where('p.idrecurso','=',6)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1  )
		   {
   
			$ultimacompra=DB::table('compras as c')
			->where('c.idusuario','=',$request->session()->get('id'))
			->orderby('c.idcompra','desc')
			->select('c.idcompra','c.estado','idusuario')
			->first();
			if($ultimacompra->estado=="1" or $ultimacompra->idusuario <> $request->session()->get('id'))
			{
				return Redirect::to('peticion/compras');
				
			}
			else{
			
			/*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
$detallecompra=DB::table('detallecompra as d')
			->join('compras as c','c.idcompra','=','d.idcompra')
			->join('producto as p','d.idproducto','=','p.idproducto')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valorcompra','d.subtotalcompra','p.idproducto','d.iddetallecompra')
			->where('d.idcompra','=',$ultimacompra->idcompra)
			->get();
$sumarray=DB::table('detallecompra as d')
			->join('compras as c','d.idcompra','=','c.idcompra')
			->join('producto as p','d.idproducto','=','p.idproducto')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetallecompra) as detalle'),DB::raw('sum(d.valorcompra) as val'),DB::raw('sum(d.subtotalcompra) as sub'),DB::raw('sum(d.utilidadcompra) as utilidad'))
			->where('d.idcompra','=',$ultimacompra->idcompra)
			->first();

			
			
			
$query=trim($request->get('p'));
$proveedores=DB::table('proveedor')->get();
$articulos = DB::table('producto as a')
			  ->join('iva as i','a.idiva','=','i.idiva')
			  ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
			  ->join('categoria as c','a.idcategoria','=','c.idcategoria')
			  ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
			  ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
			  ->where('a.codigobarra1','=',$query)
			  ->get();
$pro= DB::table('producto as a')
			  ->join('iva as i','a.idiva','=','i.idiva')
			  ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
			  ->join('categoria as c','a.idcategoria','=','c.idcategoria')
			  ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
			  ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra')
			  ->where('a.estado','=','1')
			  ->get();
	  return view("peticion.compras.create",["proveedores"=>$proveedores,"articulos"=>$articulos,"ultimacompra"=>$ultimacompra,"detallecompra"=>$detallecompra,"sumarray"=>$sumarray,"pro"=>$pro]);
			  
	  
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
			   ->where('p.idrecurso','=',6)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1 )
		   {
   
			if($request->get('ultimacompra')==0)
			{
				return Redirect::to('peticion/compras');
			}
			else
			{
				 $compra=new Compras;
				 $compra->numfactura='__';
				 $compra->valorcompra='0';
				 $compra->subtotalcompra='0';
				 $compra->idproveedor='1';
				 $compra->utilidadcompra='0';
				 $compra->idusuario=$request->get('usuario');
				 $compra->estado='0';
				 $mytime= Carbon::now('America/Bogota');
				 $compra->fecha=$mytime->toDateTimeString();
				 $compra->save();
			  return Redirect::to('peticion/compras/create');
			  
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
			   ->where('p.idrecurso','=',6)
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
		$compras=DB::table('compras as c')
			->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','p.nombreproveedor','u.user','c.numfactura','c.idcompra','c.valorcompra','c.utilidadcompra','c.estado')
			->where('c.idcompra','=',$id)
		    ->orderby('c.estado','1')
			->first();
		$detallecompra=DB::table('detallecompra as d')
		                  ->join('compras as c','c.idcompra','=','d.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valorcompra','d.subtotalcompra','p.idproducto','d.iddetallecompra')
		                  ->where('d.idcompra','=',$id)
						  ->where('c.estado','=','1')
						  ->get();
		$sumarray=DB::table('detallecompra as d')
		                  ->join('compras as c','d.idcompra','=','c.idcompra')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetallecompra) as detalle'),DB::raw('sum(d.valorcompra) as val'),DB::raw('sum(d.subtotalcompra) as sub'),DB::raw('sum(d.utilidadcompra) as utilidad'))
		                  ->where('d.idcompra','=',$id)
						  ->where('c.estado','=','1')
						  ->first();
			return view("peticion.compras.show",["compras"=>$compras,"sumarray"=>$sumarray,"detallecompra"=>$detallecompra]);
   
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
	 public function update(ComprasForRequest $request,$id)
	 
   {
	

	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',6)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1 )
	   {

		$compra=DB::table('compras as c')
		->join('detallecompra as d','d.idcompra','=','c.idcompra')
		->select('c.idcompra')
		->where('c.idcompra','=',$id)
		->first();
		
		if(sizeof($compra)==0)
		{
			return Redirect::to('peticion/compras/create')->with('mensaje2','No hay productos en la compra.')
														  ->with('proveedor',$request->get('proveedor'))
														  ->with('factura',$request->get('factura'));
		}
   else{
	   
   $compras=Compras::findOrFail($id);
   $compras->numfactura=$request->get('factura');
   $compras->valorcompra=$request->get('valorcompra');
   $compras->subtotalcompra=$request->get('subtotal');
   $compras->idproveedor=$request->get('proveedor');
   $compras->utilidadcompra=$request->get('utilidad');
   $compras->idusuario=$request->session()->get('id');
   $compras->estado="1";
   $mytime=Carbon::now('America/Bogota');
   $compras->fecha=$mytime->toDateTimeString();
   $compras->update();
   return Redirect::to('peticion/compras/')->with('mensaje','Compra realizada exitosamente!!.');


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
	 public function  productosajax(Request $request,$id)
 {
	 
	 sleep(1);
	//return $id; exit;
	
	$medicamento = DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra','a.comision')
							->where('a.descripcionproducto','LIKE','%'.$id.'%')
							->orderby('a.stock','desc')
							->get();
							
		return view("peticion.compras.busquedaproductos",["medicamento"=>$medicamento]);			
	 
	 
	 
 }
 
 public function cargaproductosajax(Request $request,$id)
 {
	 
	 sleep(1);
	 $ultimaventa=DB::table('venta as v')
			              ->where('v.idusuario','=',$request->session()->get('id'))
						  ->orderby('v.idventa','desc')
						  ->select('v.idventa','v.estado')
						  ->first();
	$articulos = DB::table('producto as a')
		                    ->join('iva as i','a.idiva','=','i.idiva')
							->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
							->join('categoria as c','a.idcategoria','=','c.idcategoria')
							->join('proveedor as p','a.idproveedor','=','p.idproveedor')
							->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra','a.comision')
							->where('a.codigobarra1','=',$id)
							->get();
							
						
	 return view("peticion.compras.ajaxproductos",["articulos"=>$articulos,"id"=>$id,"ultimaventa"=>$ultimaventa]);
	 
	 
 }
}
