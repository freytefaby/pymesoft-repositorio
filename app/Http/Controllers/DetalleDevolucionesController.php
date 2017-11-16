<?php


namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;


use hhfarm\Ventas;
use hhfarm\DetalleDevoluciones;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class DetalleDevolucionesController extends Controller
{
    public function __construct()
	{
   	
	}
	
	
	public function store(Request $request)
	{
	
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',10)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1  )
		   {
   
   
if($request->get('tipoproducto')==2)
{
	
	$subtotalcant=$request->get('preciosugerido')/$request->get('cantidadempaque')*$request->get('cant');
	$subtotaluni=$request->get('und')*$request->get('preciosugerido');
	$subtotal=$subtotalcant+$subtotaluni;
	echo "Subtotal".$subtotal; echo "<br>";
	
   $cantidad=$request->get('cantidadempaque')*$request->get('und')+$request->get('cant');
  
   echo "Cantidad".$cantidad; echo "<br>";
   
	$comision=$request->get('comision')*$cantidad;
   echo "Comision".$comision; echo "<br>";
   
   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
   echo "Valor venta".$valorventa; echo "<br>";
   
   
	$iddevolucion=$request->get('iddevolucion');
	echo "Idventa".$iddevolucion; echo "<br>";
	
	 $idproducto=$request->get('idproducto');
	echo "Idproducto".$idproducto; echo "<br>";
	
	$utilidadcant=$request->get('utilidad')/$request->get('cantidadempaque')*$request->get('cant');
	$combiva=$valorventa;
	$utilidaduni=$request->get('und')*$request->get('utilidad');
	$sumacantidad=$utilidadcant+$utilidaduni;
	$utilidadtotal=$subtotal-$sumacantidad;
	echo $utilidadtotal; 
	$codigo=$request->get('codigo');
	echo "Utilidades". $utilidadtotal; 
	
   }
   else
   {
	$subtotaluni=$request->get('preciosugerido')*$request->get('und'); 
	$subtotal=$subtotaluni;
	echo "Subtotal".$subtotal; echo "<br>"; 
	
   $cantidad=$request->get('und');
   
   echo "Cantidad".$cantidad; echo "<br>"; 
   
   $comision=$request->get('comision')*$cantidad;
   echo "comision".$comision; echo "<br>"; 
   
   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
   echo "Valor venta".$valorventa; echo "<br>"; 
   
   
	$iddevolucion=$request->get('iddevolucion');
	echo "Idventa".$iddevolucion; echo "<br>";
	
	 $idproducto=$request->get('idproducto');
	echo "Idproducto".$idproducto; echo "<br>";
	

	$combiva=$valorventa;
	$utlidaduni=$request->get('und')*$request->get('utilidad');
	$utilidadtotal=$subtotal-$utlidaduni;
	$codigo=$request->get('codigo');
	echo "Utilidades".$utilidadtotal; 
	   
   }
   $detalledevolucion=DB::table('detalledevolucioncliente as d')
				  ->join('producto as p','d.idproducto','=','p.idproducto')
				  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
				  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalledevolucioncliente')
				  ->where('d.iddevolucion','=',$iddevolucion)
				  ->where('p.idproducto','=',$idproducto)
				  ->first();
	if(sizeof($detalledevolucion)<>0)
	{
		 return Redirect::to('peticion/devoluciones/'.$iddevolucion.'?p='.$idproducto)->with('mensaje','Producto ya se encuentra en el detalle.');
			
	}
	else{
   if($request->get('cantidad_venta')<$cantidad)
		{
			 return Redirect::to('peticion/devoluciones/'.$iddevolucion.'?p='.$idproducto)->with('mensaje','La cantidad es mayor a la venta');
			
		}
		else
		{
   
   if($cantidad<=0)
   {
	   
	   return Redirect::to('peticion/devoluciones/'.$iddevolucion.'?p='.$idproducto)->with('mensaje','La cantidad no puede ser inferior a cero');
   }
   else{
		
$detalledevoluciones=new DetalleDevoluciones;
$detalledevoluciones->valor=$valorventa;
$detalledevoluciones->idproducto=$idproducto;
$detalledevoluciones->cantidad=$cantidad;
$detalledevoluciones->subtotal=$subtotal;
$detalledevoluciones->iddevolucion=$iddevolucion;
$detalledevoluciones->utilidad=$utilidadtotal;
$detalledevoluciones->comision=$comision;
$detalledevoluciones->save();
return Redirect::to('peticion/devoluciones/'.$iddevolucion.'?p='.$idproducto);
	   
	   
	   }
	   
   

   }
   
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
	 public function destroy(Request $request,$id)
   {
	 
	if($request->session()->has('id'))
	{

	   $permiso=DB::table('permiso as p')
		   ->where('p.idrol','=',$request->session()->get('perfil'))
		   ->where('p.idrecurso','=',10)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1)
	   {


		$detalle=DetalleDevoluciones::findOrFail($id);
		$detalle->delete();
		return Redirect::to('peticion/devoluciones/'.$detalle->iddevolucion);

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
