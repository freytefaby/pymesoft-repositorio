<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Productos;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\CategoriaFormRequest;
use DB;
use Session;
class InventarioProductoLaboratorioController extends Controller
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
	 $productoq=trim($request->get('producto'));
	 $codigobarraq=trim($request->get('codigobarra1'));
	 $tipoproductoq=trim($request->get('tipoproducto'));
	 $categoriaq=trim($request->get('categoria'));
	 $estadoq=trim($request->get('estado'));
	 $proveedorq=trim($request->get('proveedor'));
	
	 
	 $tipo=DB::table('tipoproducto')->get();
	 $categoria=DB::table('categoria')->get();
	 $proveedor=DB::table('proveedor')->get();
 	 $pro=DB::table('producto as p')
	 ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
	 ->join('categoria as c','c.idcategoria','=','p.idcategoria')
	 ->join('tipoproducto as t','t.idtipoproducto','=','p.idtipoproducto')
	 ->where('p.idproveedor','=',$proveedorq)
	 ->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
	 ->orwhere('p.codigobarra1','=',$codigobarraq)
	 ->paginate(7);	
	 $sumarray=DB::table('producto as p')
	 ->select(DB::raw('sum(p.stock) as numstock'), DB::raw('sum(p.preciocompra / p.cantidadempaque * p.stock) as totalcosto'))
	 ->where('p.idtipoproducto','=','2')
	 ->where('p.idproveedor','=',$proveedorq)
	 ->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
	 ->orwhere('p.codigobarra1','=',$codigobarraq)
	 ->first();
	 $sumarray2=DB::table('producto as p')
	 ->select(DB::raw('sum(p.stock) as numstock'), DB::raw('sum(p.preciocompra  * p.stock) as totalcosto'))
	 ->where('p.idtipoproducto','=','1')
	 ->where('p.idproveedor','=',$proveedorq)
	 ->where('p.descripcionproducto','LIKE','%'.$productoq.'%')
	 ->orwhere('p.codigobarra1','=',$codigobarraq)
	 ->first();
	
	$inv_venta=DB::table('producto as p')
	 ->select(DB::raw('sum(p.preciosugerido / p.cantidadempaque * p.stock) as totalventas'))
	 ->first();
	 
	 	$inv_costo=DB::table('producto as p')
	 ->select(DB::raw('sum(p.preciocompra / p.cantidadempaque * p.stock) as totalcosto'))
	 ->first();
       //$pro=Productos::producto($productoq)->codigo($codigobarraq)->proveedor($proveedorq)
	  // ->join('proveedor as p','p.idproveedor','=','1')
	   //->orderby('idproducto','DESC')->get();
	return view('peticion.inventarioproducto.index',["categoria"=>$categoria,"productoq"=>$productoq,"tipo"=>$tipo,"proveedor"=>$proveedor,"proveedorq"=>$proveedorq,"pro"=>$pro,"sumarray"=>$sumarray,"codigobarraq"=>$codigobarraq,"sumarray2"=>$sumarray2,"inv_venta"=>$inv_venta,"inv_costo"=>$inv_costo]);
		
							 
	
		 
	 }		 
			   
			   
			   
			   }   
			   else
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
