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
class Pdf_inventariolaboratorioproductoController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function show(Request $request)
   {
	  
	   
		if($request->session()->has('id'))
		{
   
		   $permiso=DB::table('permiso as p')
			   ->where('p.idrol','=',$request->session()->get('perfil'))
			   ->where('p.idrecurso','=',16)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->leer==1 )
		   {
   
			$productoq=trim($request->get('producto'));
			$codigobarraq=trim($request->get('codigo'));
			$proveedorq=trim($request->get('proveedor'));
		   
			$infoempresa=DB::table('infoempresa')
				   ->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
				   ->first();
			$tipo=DB::table('tipoproducto')->get();
			$categoria=DB::table('categoria')->get();
			$proveedor=DB::table('proveedor')->get();
			 $pro=DB::table('producto as p')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->join('categoria as c','c.idcategoria','=','p.idcategoria')
			->join('tipoproducto as t','t.idtipoproducto','=','p.idtipoproducto')
			->where('p.idproveedor','=',$proveedorq)
			->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
			->where('p.stock','>','0')
			->orwhere('p.codigobarra1','=',$codigobarraq)
			->orderby('p.descripcionproducto','asc')
			->get();		
			$sumarray=DB::table('producto as p')
			 ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select(DB::raw('sum(p.stock) as numstock'), DB::raw('sum(p.preciocompra / p.cantidadempaque * p.stock) as totalcosto'),'pr.nombreproveedor')
			->where('p.idtipoproducto','=','2')
			->where('p.idproveedor','=',$proveedorq)
			->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
			->where('p.stock','>','0')
			->orwhere('p.codigobarra1','=',$codigobarraq)
			->first();
			$sumarray2=DB::table('producto as p')
			->select(DB::raw('sum(p.stock) as numstock'), DB::raw('sum(p.preciocompra  * p.stock) as totalcosto'))
			->where('p.idtipoproducto','=','1')
			->where('p.idproveedor','=',$proveedorq)
			->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
			->where('p.stock','>','0')
			->orwhere('p.codigobarra1','=',$codigobarraq)
			->first();
			$date=Carbon::now();
	   
			   $view =  \View::make('peticion.pdf.inventariolaboratorio', compact('pro','sumarray','infoempresa','date','sumarray2'))->render();
			   $pdf = \App::make('dompdf.wrapper');
			   $pdf->loadHTML($view);
			   return $pdf->stream('invoice');
   
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
