<?php


namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;

use hhfarm\Ventas;
use hhfarm\DetalleNotaCredito;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class DetalleNotaCreditoController extends Controller
{
    public function __construct()
	{
   	
	}
	
	
	public function store(Request $request)
	{
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

if($request->get('tipoproducto')==2)
		{
			$subtotalcant=$request->get('preciosugerido')/$request->get('cantidadempaque')*$request->get('cant');
	        $subtotaluni=$request->get('und')*$request->get('preciosugerido');
			$subtotal=$subtotalcant+$subtotaluni;
			echo "Subtotal".$subtotal; echo "<br>";
			
		   $cantidad=$request->get('cantidadempaque')*$request->get('und')+$request->get('cant');
		  
		   echo "Cantidad".$cantidad; echo "<br>";
		   
		   
		   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
		   echo "Valor venta".$valorventa; echo "<br>";
		   
		   
		    $idnota=$request->get('idnota');
			echo "Idventa".$idnota; echo "<br>";
			
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
		   
		   
		   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
		   echo "Valor venta".$valorventa; echo "<br>"; 
		   
		   
		    $idnota=$request->get('idnota');
			echo "Idventa".$idnota; echo "<br>";
			
			 $idproducto=$request->get('idproducto');
			echo "Idproducto".$idproducto; echo "<br>";
			
		
			$combiva=$valorventa-$subtotal; 
			
			$utlidaduni=$request->get('und')*$request->get('utilidad');
			$utilidadtotal=$subtotal-$utlidaduni;
			$codigo=$request->get('codigo');
			echo "Utilidades".$utilidadtotal; 
			   
		   }
		    if($cantidad > $request->get('stock'))
		   {
			    return Redirect::to('peticion/ventas/create')->with('mensaje','Cantidad no debe superar el stock');
		   }
		   
		   if($cantidad<=0)
		   {
			   
			   return Redirect::to('peticion/notascredito/create')->with('mensaje','La cantidad no puede ser inferior a cero');;
		   }
		   else{
	   $detallenotacredito=new DetalleNotaCredito;
	   $detallenotacredito->idproducto=$idproducto;
	   $detallenotacredito->cantidad=$cantidad;
	   $detallenotacredito->valor=$valorventa;
	   $detallenotacredito->subtotal=$subtotal;
	   $detallenotacredito->utilidades=$utilidadtotal;
	   $detallenotacredito->idnotacredito=$idnota;
	   $detallenotacredito->save();
	return Redirect::to('peticion/notascredito/create?p='.$idproducto);
			   
			   
			   
			   
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
	 public function destroy(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

$detalle=DetalleNotaCredito::findOrFail($id);
	 $detalle->delete();
	 return Redirect::to('peticion/notascredito/create?p='.$detalle->idproducto);

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
