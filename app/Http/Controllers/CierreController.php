<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\CierreForRequest;

use hhfarm\CierreDiario;
use hhfarm\DetalleVentas;
use hhfarm\Gasto;
use hhfarm\Ingreso;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class CierreController extends Controller
{
    public function __construct()
	{
   	
	}
	public function index(Request $request)
	{
		
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2 )
			   {

if($request)
		{
			
			$ultimocierre=DB::table('cierre_diario as c')
						  ->orderby('c.idcierrediario','desc')
						  ->select('c.idcierrediario','c.estado')
						  ->first();
           // $date = Carbon::now();
            //$date = $date->format('Y-m-d');						  
			$query=trim($request->get('searchText'));
			$cierre=DB::table('cierre_diario as c')
			->join('usuarios as u','u.idusuario','=','c.idusuario')
			->select('c.fecha','c.estado','c.idcierrediario','u.idusuario','c.valorventa','c.subtotal','c.gastos','c.base','c.recogida','c.fechacierre','c.utilidades')
		    ->orderby('c.fecha','desc')
			->get();
			$date=Carbon::now();
			return view('peticion.cierre.index',["cierre"=>$cierre,"searchText"=>$query,"ultimocierre"=>$ultimocierre,"date"=>$date]);
			
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
	public function create(Request $request)
	
	{
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {


$ultimocierre=DB::table('cierre_diario as c')
						  ->orderby('c.idcierrediario','desc')
						  ->select('c.idcierrediario','c.estado')
						  ->first();
						  if($ultimocierre->estado=="1")
						  {
							  return Redirect::to('peticion/cierrediario');
							  
						  }
						  else{
	    $query=trim($request->get('fecha'));
		$exist=DB::table('cierre_diario')
                    ->where('fechacierre','=',$query)
					->first();
		if(sizeof($exist)<>0 and $exist->estado==1)
		{
			 return Redirect::to('peticion/cierrediario/create?fecha="Null"')->with('mensaje','Esta fecha de cierre actualmente ya se encuentra generada');
			 
		}
					
	
	
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.utilidades','v.descuento','v.comision')
		    ->where('v.fecha','LIKE','%'.$query.'%')
			->where('v.estado','=','1')
			->orderby('v.idventa','desc')
			->get();
			
		 
			
						  /*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
		
		$sumarray=DB::table('venta as v')
						  ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),DB::raw('sum(v.descuento) as descuentos'),DB::raw('sum(v.comision) as com'))
						  ->where('v.fecha','LIKE','%'.$query.'%')
						  ->first();
		
						  
						  
						  
		
		
			$tiposventa=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
			                     ->groupBy('t.idtipoventa')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->get();
		    $convenios=DB::table('venta as v')
		                        ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->where('v.idtipoventa','=',5)
								 ->first();

		$abonos=DB::table('detalle_abono as da')
			   ->join('convenio as c','c.idconvenio','=','da.idconvenio')
			   ->join('clientes as cl','cl.idcliente','=','da.idcliente')
			   ->where('da.fecha_abono','LIKE','%'.$query.'%')
			   ->get();
		     
			$ventausuarios=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'u.user',DB::raw('sum(v.comision) as comision'),DB::raw('sum(v.devolucion) as dev'),DB::raw('sum(v.comision_devolucion) as devcomision'))
			                     ->groupBy('u.idusuario')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->where('v.estado','=','1')
								 ->get();
			$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->where('d.fecha','LIKE','%'.$query.'%')
						  ->get();
			$notacredito=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->get();
			$sumanota=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->select(DB::raw('sum(valornotacredito) as valnota'),DB::raw('sum(utilidades) as utilidad'),DB::raw('sum(subtotal) as subtotalnota'))
						  ->first();
			 $gasto=DB::table('gasto')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumagasto=DB::table('gasto')
			                ->select(DB::raw('sum(valorgasto) as gasto'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$base=DB::table('base_caja')->first();
			
			$sumadev=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select(DB::raw('sum(d.valordevolucion) as devolucion'), DB::raw('sum(d.utilidades) as utilidadsuma'),DB::raw('sum(d.subtotal) as subdev'),DB::raw('sum(d.comision) as com_dev'))
						  ->where('d.fecha','LIKE','%'.$query.'%')
						  ->first();
			$ingreso=DB::table('otro_ingreso')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumaingreso=DB::table('otro_ingreso')
			                ->select(DB::raw('sum(valoringreso) as ingreso'),DB::raw('sum(utilidadingreso) as utilidad'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$compra=DB::table('compras as c')
			              ->select('idcompra','user','valorcompra')
			              ->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','c.idusuario')
		                  ->where('c.fecha','LIKE','%'.$query.'%')
						  ->where('c.estado','=','1')
						  ->get();
			$salida_productos=DB::table('detalleventa as v')
			                    ->select('p.descripcionproducto','p.stock','p.codigobarra1',DB::raw('sum(v.cantidad) as cant'))
			                     ->join('producto as p','p.idproducto','=','v.idproducto')
								 ->join('venta as ve','ve.idventa','=','v.idventa')
								 ->where('ve.fecha','LIKE','%'.$query.'%')
								 ->where('ve.estado','=','1')
								 ->groupBy('p.idproducto')
								 ->get();
			
					return view("peticion.cierre.create",["ventas"=>$ventas,"sumarray"=>$sumarray,"tiposventa"=>$tiposventa,"ventausuarios"=>$ventausuarios,"ultimocierre"=>$ultimocierre,"query"=>$query,"devoluciones"=>$devoluciones,"gasto"=>$gasto,"sumagasto"=>$sumagasto,"base"=>$base,"sumadev"=>$sumadev,"ingreso"=>$ingreso,"sumaingreso"=>$sumaingreso,"notacredito"=>$notacredito,"sumanota"=>$sumanota,"compra"=>$compra,"salida_productos"=>$salida_productos,"convenios"=>$convenios,"abonos"=>$abonos]);
							
		            
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
	public function store(Request $request)
	{
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2   )
			   {
$query=trim($request->get('fecha'));
$exist=DB::table('cierre_diario')
                    ->where('fechacierre','=',$query)
					->first();
		if(sizeof($exist)<>0 and $exist->estado==1)
		{
			 return Redirect::to('peticion/cierrediario/create')->with('mensaje','Esta fecha de cierre actualmente ya se encuentra generada');
			 
		}
if($request->get('ultimocierre')==0)
  {
	  return Redirect::to('peticion/cierrediario');
  }
  else
  {
	   $cierre=new CierreDiario;
	   $cierre->valorventa='0';
	   $cierre->idusuario=$request->get('usuario');
	   $cierre->subtotal='0';
	   $cierre->comisionventa='0';
	   $cierre->utilidades='0';
	   $cierre->comisionventa='0';
	   $mytime= Carbon::now('America/Bogota');
	   $cierre->fecha=$mytime->toDateTimeString();
	   $cierre->fechacierre=$mytime->toDateTimeString();
	   $cierre->base='0';
	   $cierre->gastos='0';
	   $cierre->estado='0';
	   $cierre->recogida='0';
	   $cierre->save();
	   $date=Carbon::now();
	   $date->toDateString();
	return Redirect::to('peticion/cierrediario/create?fecha='.$date);
	
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
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {

$exist=DB::table('cierre_diario')
                    ->where('idcierrediario','=',$id)
					->first();
		
			$query=$exist->fechacierre;		
	
	
			$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.utilidades','v.descuento','v.comision')
		    ->where('v.fecha','LIKE','%'.$query.'%')
			->where('v.estado','=','1')
			->orderby('v.idventa','desc')
			->get();
			
		 
			
						  /*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
		
		$sumarray=DB::table('venta as v')
						  ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),DB::raw('sum(v.descuento) as descuentos'),DB::raw('sum(v.comision) as com'))
						  ->where('v.fecha','LIKE','%'.$query.'%')
						  ->first();
		
						  
						  
						  
		
		
			$tiposventa=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
			                     ->groupBy('t.idtipoventa')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->get();
		    $convenios=DB::table('venta as v')
		                        ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'t.desctipoventa')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->where('v.idtipoventa','=',5)
								 ->first();

		$abonos=DB::table('detalle_abono as da')
			   ->join('convenio as c','c.idconvenio','=','da.idconvenio')
			   ->join('clientes as cl','cl.idcliente','=','da.idcliente')
			   ->where('da.fecha_abono','LIKE','%'.$query.'%')
			   ->get();
		     
			$ventausuarios=DB::table('venta as v')
			                     ->join('usuarios as u','u.idusuario','=','v.idusuario')
								 ->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			                     ->select(DB::raw('sum(v.valorventa) as valorventa'),DB::raw('count(v.idventa) as numventas'),DB::raw('sum(v.subtotal) as subtotal'),DB::raw('sum(v.utilidades) as utilidades'),DB::raw('sum(v.importeventa) as importe'),'u.user',DB::raw('sum(v.comision) as comision'),DB::raw('sum(v.devolucion) as dev'),DB::raw('sum(v.comision_devolucion) as devcomision'))
			                     ->groupBy('u.idusuario')
								 ->where('v.fecha','LIKE','%'.$query.'%')
								 ->where('v.estado','=','1')
								 ->get();
			$devoluciones=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select('d.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idtipoventa','v.idventa','d.valordevolucion','d.iddevolucioncliente','d.observacion')
						  ->where('d.fecha','LIKE','%'.$query.'%')
						  ->get();
			$notacredito=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->get();
			$sumanota=DB::table('notacredito as n')
			              ->join('clientes as c','c.idcliente','=','n.idcliente')
			              ->join('usuarios as u','u.idusuario','=','n.idusuario')
						  ->where('n.fecha','LIKE','%'.$query.'%')
						  ->select(DB::raw('sum(valornotacredito) as valnota'),DB::raw('sum(utilidades) as utilidad'),DB::raw('sum(subtotal) as subtotalnota'))
						  ->first();
			 $gasto=DB::table('gasto')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumagasto=DB::table('gasto')
			                ->select(DB::raw('sum(valorgasto) as gasto'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$base=DB::table('base_caja')->first();
			
			$sumadev=DB::table('devolucionescliente as d')
			              ->join('clientes as c','c.idcliente','=','d.idcliente')
			              ->join('usuarios as u','u.idusuario','=','d.idusuario')
						  ->join('venta as v','v.idventa','=','d.idventa')
						  ->select(DB::raw('sum(d.valordevolucion) as devolucion'), DB::raw('sum(d.utilidades) as utilidadsuma'),DB::raw('sum(d.subtotal) as subdev'),DB::raw('sum(d.comision) as com_dev'))
						  ->where('d.fecha','LIKE','%'.$query.'%')
						  ->first();
			$ingreso=DB::table('otro_ingreso')
		                    ->where('fecha','LIKE','%'.$query.'%')
							->get();
			$sumaingreso=DB::table('otro_ingreso')
			                ->select(DB::raw('sum(valoringreso) as ingreso'),DB::raw('sum(utilidadingreso) as utilidad'))
		                    ->where('fecha','LIKE','%'.$query.'%')
							->first();
			$compra=DB::table('compras as c')
			              ->select('idcompra','user','valorcompra')
			              ->join('proveedor as p','p.idproveedor','=','c.idproveedor')
			              ->join('usuarios as u','u.idusuario','=','c.idusuario')
		                  ->where('c.fecha','LIKE','%'.$query.'%')
						  ->where('c.estado','=','1')
						  ->get();
			$salida_productos=DB::table('detalleventa as v')
			                    ->select('p.descripcionproducto','p.stock','p.codigobarra1',DB::raw('sum(v.cantidad) as cant'))
			                     ->join('producto as p','p.idproducto','=','v.idproducto')
								 ->join('venta as ve','ve.idventa','=','v.idventa')
								 ->where('ve.fecha','LIKE','%'.$query.'%')
								 ->where('ve.estado','=','1')
								 ->groupBy('p.idproducto')
								 ->get();
			 
			
					return view("peticion.cierre.show",["ventas"=>$ventas,"sumarray"=>$sumarray,"tiposventa"=>$tiposventa,"ventausuarios"=>$ventausuarios,"query"=>$query,"devoluciones"=>$devoluciones,"gasto"=>$gasto,"sumagasto"=>$sumagasto,"base"=>$base,"exist"=>$exist,"sumadev"=>$sumadev,"ingreso"=>$ingreso,"sumaingreso"=>$sumaingreso,"notacredito"=>$notacredito,"sumanota"=>$sumanota,"compra"=>$compra,"salida_productos"=>$salida_productos,"abonos"=>$abonos,"convenios"=>$convenios]);
						


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
	 public function update(CierreForRequest $request,$id)
	 
   {
	  
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {

		

	  
       $cierre=CierreDiario::findOrFail($id);
	   $cierre->valorventa=$request->get('ventas');
	   $cierre->idusuario=$request->get('idusuario');
	   $cierre->subtotal=$request->get('subtotal');
	   $cierre->utilidades=$request->get('utilidades');
	   $cierre->fechacierre=$request->get('fecha');
	   $cierre->gastos=$request->get('gastos');
	   $cierre->base=$request->get('base');
	   $cierre->estado='1';
	   $cierre->recogida=$request->get('recogida');
	   $cierre->update();
	   
	   $cont=0;
	   while($cont < count($request->get('idgasto')))
	   {
		   $id=$request->get('idgasto')[$cont];
		   $gasto=Gasto::findOrFail($id);
		   $gasto->estado='1';
		   $gasto->update();
		   $cont=$cont+1;
		   
	   }
	   $cont2=0;
	   while($cont2 < count($request->get('idingreso')))
	   {
		   $id2=$request->get('idingreso')[$cont2];
		   $ingreso=Ingreso::findOrFail($id2);
		   $ingreso->estado='1';
		   $ingreso->update();
		   $cont2=$cont2+1;
		   
	   }
	   
	   
	   return Redirect::to('peticion/cierrediario/')->with('mensaje','Cierre realizado exitosamente');
   

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
