<?php


namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;

use hhfarm\Ventas;
use hhfarm\Productos;
use hhfarm\DetalleCompras;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class DetalleCompraController extends Controller
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
			   ->where('p.idrecurso','=',6)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==6 )
		   {
   
			if($request->get('tipoproducto')==2)
			{
				
				
				$subtotalcant=$request->get('preciocompra')/$request->get('cantidadempaque')*$request->get('cant');
				$subtotaluni=$request->get('und')*$request->get('preciocompra');
				$subtotal=$subtotalcant+$subtotaluni;
				echo "Subtotal".$subtotal; echo "<br>";
				
				$preciosugeridocant=$request->get('preciosugerido')/$request->get('cantidadempaque')*$request->get('cant');
				$preciosugeridouni=$request->get('und')*$request->get('preciosugerido');
				$preciosugerido=$preciosugeridocant+$preciosugeridouni;
				echo "preciosugerido".$preciosugerido; echo "<br>";
				
			   $cantidad=$request->get('cantidadempaque')*$request->get('und')+$request->get('cant');
			  
			   echo "Cantidad".$cantidad; echo "<br>";
			   
			   
			   $valorcompra=$subtotal*$request->get('iva')/100+$subtotal;
			   echo "Valor venta".$valorcompra; echo "<br>";
			   
			   
				$idcompra=$request->get('idcompra');
				echo "Idcompra".$idcompra; echo "<br>";
				
				 $idproducto=$request->get('idproducto');
				echo "Idproducto".$idproducto; echo "<br>";
				
				$utilidadcant=$request->get('preciocompra')/$request->get('cantidadempaque')*$request->get('cant');
				$combiva=$valorcompra;
				$utilidaduni=$request->get('und')*$request->get('preciocompra');
				$sumacantidad=$utilidadcant+$utilidaduni;
				$utilidadtotal=$preciosugerido-$sumacantidad;
				$codigo=$request->get('codigo');
				echo "Utilidades". $utilidadtotal; 
				
				
				
			
				
			   }
			   else
			   {
				$subtotaluni=$request->get('preciocompra')*$request->get('und'); 
				$subtotal=$subtotaluni;
				echo "Subtotal".$subtotal; echo "<br>"; 
			
			
				$preciosugeridouni=$request->get('und')*$request->get('preciosugerido');
				$preciosugerido=$preciosugeridouni;
				echo "preciosugerido".$preciosugerido; echo "<br>";
				
			   $cantidad=$request->get('und');
			   
			   echo "Cantidad".$cantidad; echo "<br>"; 
			   
			   
			   $valorcompra=$subtotal*$request->get('iva')/100+$subtotal;
			   echo "Valor venta".$valorcompra; echo "<br>"; 
			   
			   
				$idcompra=$request->get('idcompra');
				echo "Idcompra".$idcompra; echo "<br>";
				
				 $idproducto=$request->get('idproducto');
				echo "Idproducto".$idproducto; echo "<br>";
				
			
				$combiva=$valorcompra;
				$utlidaduni=$request->get('und')*$request->get('preciocompra');
				$utilidadtotal=$preciosugerido-$utlidaduni;
				$codigo=$request->get('codigo');
				echo "Utilidades".$utilidadtotal; 
				   
			   }
			   
			   if($cantidad<=0)
			   {
				   
				   return Redirect::to('peticion/compras/create')->with('mensaje','La cantidad no puede ser inferior a cero');;
			   }
			   else{
		   $detallecompra=new DetalleCompras;
		   $detallecompra->idcompra=$idcompra;
		   $detallecompra->idproducto=$idproducto;
		   $detallecompra->valorcompra=$valorcompra;
		   $detallecompra->utilidadcompra=$utilidadtotal;
		   $detallecompra->subtotalcompra=$subtotal;
		   $detallecompra->cantidad=$cantidad;
		   $detallecompra->save();
		   
		  $producto=Productos::findOrFail($idproducto);
		  $producto->preciocompra=$request->get('preciocompra');
		  $producto->preciosugerido=$request->get('preciosugerido');
		  $producto->update();
		return Redirect::to('peticion/compras/create?p='.$request->get('codigoproducto'));
				   
				   
				   
				   
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
		   ->where('p.idrecurso','=',6)
		   ->first();
   if(count($permiso)==0)
   {
	   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
   }else

   {


	   if($permiso->crear==1)
	   {

		$detalle=DetalleCompras::findOrFail($id);
		$detalle->delete();
		return Redirect::to('peticion/compras/create?p='.$detalle->idproducto);

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
