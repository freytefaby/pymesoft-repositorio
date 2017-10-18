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

class DetalleVentaController extends Controller
{
    public function __construct()
	{
   	
	}
	
	
	public function store(Request $request)
	{
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 OR $request->session()->get('perfil')==2  )
			   {
             if ($request->ajax()){
				
				 if($request->get('tipoproducto')==2)
		{
			
			$subtotalcant=$request->get('preciosugerido')/$request->get('cantidadempaque')*$request->get('cant');
	        $subtotaluni=$request->get('und')*$request->get('preciosugerido');
			$subtotal=$subtotalcant+$subtotaluni;
			//echo "Subtotal".$subtotal; echo "<br>";
			
		   $cantidad=$request->get('cantidadempaque')*$request->get('und')+$request->get('cant');
		  
		   //echo "Cantidad".$cantidad; echo "<br>";
		   
		   
		   $comision=$request->get('comision')*$cantidad;
		   //echo "Comision".$comision; echo "<br>";
		   
		   
		   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
		   //echo "Valor venta".$valorventa; echo "<br>";
		   
		   
		    $idventa=$request->get('idventa');
			//echo "Idventa".$idventa; echo "<br>";
			
			 $idproducto=$request->get('idproducto');
			//echo "Idproducto".$idproducto; echo "<br>";
			
			$utilidadcant=$request->get('utilidad')/$request->get('cantidadempaque')*$request->get('cant');
			$combiva=$valorventa;
			$utilidaduni=$request->get('und')*$request->get('utilidad');
			$sumacantidad=$utilidadcant+$utilidaduni;
			$utilidadtotal=$subtotal-$sumacantidad;
			
			//echo $utilidadtotal; 
			$codigo=$request->get('codigo');
			//echo "Utilidades". $utilidadtotal; 
			
		   }
		   else
		   {
			$subtotaluni=$request->get('preciosugerido')*$request->get('und'); 
			$subtotal=$subtotaluni;
			//echo "Subtotal".$subtotal; echo "<br>"; 
			
		   $cantidad=$request->get('und');
		   
		   //echo "Cantidad".$cantidad; echo "<br>"; 
		   
		   $comision=$request->get('comision')*$cantidad;
		  // echo "comision".$comision; echo "<br>"; 
		   
		   $valorventa=$subtotal*$request->get('iva')/100+$subtotal;
		   //echo "Valor venta".$valorventa; echo "<br>"; 
		   
		   
		    $idventa=$request->get('idventa');
			//echo "Idventa".$idventa; echo "<br>";
			
			 $idproducto=$request->get('idproducto');
			//echo "Idproducto".$idproducto; echo "<br>";
			
		
			$combiva=$valorventa;
			$utlidaduni=$request->get('und')*$request->get('utilidad');
			$utilidadtotal=$subtotal-$utlidaduni;
			$codigo=$request->get('codigo');
			//echo "Utilidades".$utilidadtotal."<br>"; 
			 
		   }
		    
		   if($cantidad > $request->get('stock'))
		   {
			   return response()->json([
				 "mensaje"=>"STOCK MAYOR A SU CANTIDAD"
				 ]);
		   }
		   if($cantidad<=0)
		   {
			   
			  return response()->json([
				 "mensaje"=>"CANTIDAD NO PUEDE SER INFERIOR A CERO"
				 ]);
		   }
		   else{
			   $products=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
		                  ->where('d.idventa','=',$idventa)
						  ->where('d.idproducto','=',$idproducto)
						  ->orderby('d.iddetalleventa','desc')
						  ->first();
						  
			   if(sizeof($products)>0)
			   {
				   	 return response()->json([
				 "mensaje"=>"Producto ya se encuentra en detalle, favor eliminelo y corrija la cantidad"
				 ]);
			   }
			   
			   //print_r($_POST); exit;
	   $codigobarras=$request->get('codigo_barra');
	   $detalleventa=new DetalleVentas;
	   $detalleventa->valor=$valorventa;
	   $detalleventa->idproducto=$idproducto;
	   $detalleventa->cantidad=$cantidad;
	   $detalleventa->subtotal=$subtotal;
	   $detalleventa->idventa=$idventa;
	   $detalleventa->utilidad=$utilidadtotal;
	   $detalleventa->comision=$comision;
	   $detalleventa->save();
	 return response()->json([
				 "mensaje"=>"3"
				 ]);
			   
			   
			   
			   
		   }
				 
				 
			 }

		   //print_r($_POST); EXIT;
		   

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
	   
  if($request->session()->get('perfil')==1 OR $request->session()->get('perfil')==2  )
			   {

     $detalle=DetalleVentas::findOrFail($id);
	 $detalle->delete();
	 return Redirect::to('peticion/ventas/create?p='.$detalle->codigobarra1);

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
