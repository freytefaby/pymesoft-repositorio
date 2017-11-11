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
class Pdf_FacturaController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function show(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2 )
			   {

 $infoempresa=DB::table('infoempresa')
			->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
			->first();
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','u.nombreusuario','u.apellidousuario')
			->where('v.idventa','=',$id)
			->where('v.estado','=','1')
			->get();
			$ventas2=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','u.nombreusuario','u.apellidousuario')
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
						  $nombre="HHCD-00".$ventas2->idtipoventa.$ventas2->idventa; 
						  Header("Content-Type: text/plain"); 
						  Header("Content-Disposition: attachment; filename=$nombre.txt"); 
						  echo "        ".$infoempresa->nombrecomercialempresa."\r\n"; 
						  echo "          Dirección:"." ".$infoempresa->telefonoempresa."\r\n"; 
						  echo "             Tel:"." ".$infoempresa->telefonoempresa."\r\n"; 
						  echo "          Nit:"." ".$infoempresa->nitempresa."\r\n"; 
						  echo "       Ciudad:"." ".$infoempresa->ciudadempresa."\r\n";
						  
						  
						  echo "=======================================\r\n"; 
						  echo "           Fac HHCD-00".$ventas2->idtipoventa.$ventas2->idventa."\r\n"; 
						  echo "=======================================\r\n"; 
						  echo "Producto      Cantidad Valor\r\n"; 
						  foreach($detalleventa as $detail)
						  {
						  echo$detail->descripcionproducto."\r\n";
						  echo "              ".$detail->cantidad."        ".number_format($detail->subtotal)."\r\n";
  
						  }
						 
						  echo "=======================================\r\n";
						  echo "No. productos:".$sumarray->detalle."\r\n"; 
						  foreach($ventas as $vent)
						  {
							echo "Recargo Iva: ".number_format($vent->valorventa-$vent->subtotal)."\r\n";
							echo "Subtotal: ".number_format($vent->subtotal)."\r\n";
							echo "Total a pagar: ".number_format($vent->valorventa)."\r\n";
							echo "Recibido: ".number_format($vent->importeventa)."\r\n";
							echo "Cambio: ".number_format($vent->importeventa-$vent->valorventa)."\r\n";
						  }
						  echo "=======================================\r\n";
						  foreach($ventas as $vent)
						  {
							echo "Vendedor: ".$vent->nombreusuario."\r\n";
							echo "Cliente: ".$vent->nombrecliente."\r\n";
						  }
						  echo "=======================================\r\n";
						  echo "MUCHAS GRACIAS POR TU COMPRA\r\n";
						  echo "TE ESPERAMOS NUEVAMENTE!!\r\n";
						  
						 
					
       /* $view =  \View::make('peticion.pdf.factura_venta', compact('infoempresa','ventas','detalleventa','sumarray'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');*/

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
   
   public function carta(Request $request,$id)
   
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2 )
			   {

 $infoempresa=DB::table('infoempresa')
			->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
			->first();
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','u.nombreusuario','u.apellidousuario','c.direccioncliente','c.telefonocliente','c.cedulacliente')
			->where('v.idventa','=',$id)
			->where('v.estado','=','1')
			->get();
			
		$detalleventa=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalleventa','p.preciosugerido','d.valor')
		                  ->where('d.idventa','=',$id)
						  ->where('v.estado','=','1')
						  ->get();
		$sumarray=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalleventa) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'),DB::raw('sum(d.subtotal) as subtotal'))
		                  ->where('d.idventa','=',$id)
						  ->where('v.estado','=','1')
						  ->first();

						  

        $view =  \View::make('peticion.pdf.factura_ventacarta', compact('infoempresa','ventas','detalleventa','sumarray'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

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
