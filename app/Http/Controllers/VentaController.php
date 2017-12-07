<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;

use hhfarm\Ventas;
use hhfarm\DetalleVentas;
use hhfarm\Convenio;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class VentaController extends Controller
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
			->where('p.idrecurso','=',1)
			->first();
	if(count($permiso)==0)
	{
		return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	}else

	{
          

		if($permiso->leer==1)
		{


			if($request)
			{
				$clientes=DB::table('clientes')->get();
				$ultimaventa=DB::table('venta as v')
							  ->where('v.idusuario','=',$request->session()->get('id'))
							  ->orderby('v.idventa','desc')
							  ->select('v.idventa','v.estado')
							  ->first();
			   // $date = Carbon::now();
				//$date = $date->format('Y-m-d');						  
				$query=trim($request->get('searchText'));
				$ventas=DB::table('venta as v')
				->join('clientes as c','c.idcliente','=','v.idcliente')
				->join('usuarios as u','u.idusuario','=','v.idusuario')
				->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
				->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','c.cedulacliente','v.descuento','t.idtipoventa')
				->where('v.idusuario','=',$request->session()->get('id'))
				->orderby('v.idventa','desc')
				->limit(100)
				->get();
				return view('peticion.ventas.index',["ventas"=>$ventas,"searchText"=>$query,"ultimaventa"=>$ultimaventa,"clientes"=>$clientes]);
				
			}



							  }   
		else
{
return Redirect::to('peticion/error')->with('mensaje','No tiene permisos necesarios para acceder a este contenido, Comunicarse con sistemas');
			
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
			   ->where('p.idrecurso','=',1)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1  )
		   {
   
			$ultimaventa=DB::table('venta as v')
			->where('v.idusuario','=',$request->session()->get('id'))
			->orderby('v.idventa','desc')
			->select('v.idventa','v.estado')
			->first();
			if($ultimaventa->estado=="1")
			{
				return Redirect::to('peticion/ventas');
				
			}
			else{
			
			/*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/



			
			
			
$query=trim($request->get('p'));


$pro= DB::table('producto as a')
			  ->join('iva as i','a.idiva','=','i.idiva')
			  ->join('tipoproducto as t','a.idtipoproducto','=','t.idtipoproducto')
			  ->join('categoria as c','a.idcategoria','=','c.idcategoria')
			  ->join('proveedor as p','a.idproveedor','=','p.idproveedor')
			  ->select('a.idproducto','a.descripcionproducto','p.nombreproveedor','a.codigobarra1','a.stock','a.precioventa','a.preciosugerido','a.cantidadempaque','a.idtipoproducto','i.valoriva','a.preciocompra','a.activo_principio')
			  ->where('a.estado','=','1')
			  ->get();
	  return view("peticion.ventas.create",["ultimaventa"=>$ultimaventa,"pro"=>$pro,"query"=>$query]);
			  
	  
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
			   ->where('p.idrecurso','=',1)
			   ->first();
	   if(count($permiso)==0)
	   {
		   return Redirect::to('peticion/error')->with('mensaje','No existe ningun recurso disponible para este empleado');
	   }else
   
	   {
   
   
		   if($permiso->crear==1 )
		   {
   
			if($request->get('ultimaventa')==0)
			{
				return Redirect::to('peticion/ventas');
			}
			else
			{
				 $venta=new Ventas;
				 $venta->valorventa='0';
				 $venta->idusuario=$request->get('usuario');
				 $venta->idcliente='1';
				 $venta->subtotal='0';
				 $venta->comisionventa='0';
				 $venta->utilidades='0';
				 $mytime= Carbon::now('America/Bogota');
				 $venta->fecha=$mytime->toDateTimeString();
				 $venta->importeventa='0';
				 $venta->idtipoventa='1';
				 $venta->comision='0';
				 $venta->save();
			  return Redirect::to('peticion/ventas/create');
			  
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
			   ->where('p.idrecurso','=',1)
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
		$ventas=DB::table('venta as v')
			->join('clientes as c','c.idcliente','=','v.idcliente')
			->join('usuarios as u','u.idusuario','=','v.idusuario')
			->join('tipoventa as t','t.idtipoventa','=','v.idtipoventa')
			->select('v.fecha','c.nombrecliente','c.apellidocliente','u.user','v.idventa','v.valorventa','v.importeventa','v.estado','v.subtotal','v.idtipoventa','t.desctipoventa','u.nombreusuario','u.apellidousuario','c.nombrecliente','c.apellidocliente')
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
			return view("peticion.ventas.show",["ventas"=>$ventas,"sumarray"=>$sumarray,"detalleventa"=>$detalleventa]);





   
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
	 public function update(VentaForRequest $request,$id)
	 
   {
	   if($request->session()->has('id'))
	 {
	   
 

 $ventas=DB::table('venta as v')
			->join('detalleventa as d','d.idventa','=','v.idventa')
			->select('v.idventa')
			->where('v.idventa','=',$id)
			->first();
			
			if(sizeof($ventas)==0)
			{
				return response()->json(["mensaje"=>"No hay productos en la venta."] );
				
			}
	   else{
		    $venta=$request->get('valorventa')- $request->get('descuento');
		  
		  
		   if($request->get('valor')<$venta)
		   {
			   return response()->json(["mensaje"=>"El valor digitado es inferior a la venta"] );

		   }
		   else
		   {
			   switch ($request->get('tipoventa')) {
				   case '5':
				   $convenio=DB::table('venta as v')
				   ->join('clientes as c','v.idcliente','=','c.idcliente')
				   ->join('usuarios as u','u.idusuario','=','v.idusuario')
				   ->join('cupo as co','co.idcliente','=','c.idcliente')
				   ->select(DB::raw('sum(v.valorventa) as ventas'),'v.fecha')
				   ->where('v.idcliente','=',$request->get('cliente'))
				   ->where('v.idtipoventa','=',5)
				   ->where('v.convenio','=',1)
				   ->orderby('v.fecha','asc')
				   ->first();
			$cupo=DB::table('cupo')
					->where('idcliente','=',$request->get('cliente'))
					->first();
			if(sizeof($cupo)==0)
			{
				return response()->json(["mensaje"=>"Usuario no tiene cupo en el sistema."]);
			}		
				if(sizeof($convenio->ventas)==0)
				{
					$valor= $request->get('valorventa');
					if ( $valor > $cupo->max_credito  ) {
						return response()->json(["mensaje"=>"Excedio cupo maximo"." ".number_format($cupo->max_credito)."<br> Valor de convenio"." ".number_format($convenio->ventas + $request->get('valorventa'))]);
					}
					
						
				$venta=Ventas::findOrFail($id);
				$venta->valorventa=$request->get('valorventa');
				$venta->idcliente=$request->get('cliente');
				$venta->subtotal=$request->get('subtotal');
				$venta->utilidades=$request->get('utilidad2')-$request->get('descuento');
				$mytime=Carbon::now('America/Bogota');
				$venta->fecha=$mytime->toDateTimeString();
				$venta->importeventa=$request->get('valor');
				$venta->estado='1';
				$venta->idtipoventa=$request->get('tipoventa');
				$venta->descuento=$request->get('descuento');
				$venta->comision=$request->get('comis');
              if($request->get('tipoventa')==5)
				{
					$venta->convenio='1';
				}
				else
				{
					$venta->convenio='0';
				}
				$venta->update();
				Session::flash('venta_creada', 'HHF-00'.$request->get('tipoventa').$id);
				Session::flash('valorventa', number_format($request->get('valorventa')));
				Session::flash('efectivo', number_format($request->get('valor')));
				Session::flash('cambio', number_format($request->get('valor') - $request->get('valorventa') ));
				return response()->json(["mensaje"=>"success"] ); 
				}


			$fecha = strtotime ( '+'.$cupo->dias_credito.' day' , strtotime ( $convenio->fecha ) ) ;
			$reset = date ( 'Y-m-d h:m:s' , $fecha );
		   if($mytime=Carbon::now('America/Bogota') >= $reset    )
		   {
			
			return response()->json(["mensaje"=>"Cancelado fecha limite de pago convenios <br>"." ".fecha($reset)]);
			  
			   
		   }
			else
		   {
                $valor=$convenio->ventas + $request->get('valorventa');
			if ( $valor > $cupo->max_credito  ) {
				return response()->json(["mensaje"=>"Excedio cupo maximo"." ".number_format($cupo->max_credito)."<br> Valor de convenio"." ".number_format($convenio->ventas + $request->get('valorventa'))]);
			} else {

				$venta=Ventas::findOrFail($id);
				$venta->valorventa=$request->get('valorventa');
				$venta->idcliente=$request->get('cliente');
				$venta->subtotal=$request->get('subtotal');
				$venta->utilidades=$request->get('utilidad2')-$request->get('descuento');
				$mytime=Carbon::now('America/Bogota');
				$venta->fecha=$mytime->toDateTimeString();
				$venta->importeventa=$request->get('valor');
				$venta->estado='1';
				$venta->idtipoventa=$request->get('tipoventa');
				$venta->descuento=$request->get('descuento');
				$venta->comision=$request->get('comis');
				if($request->get('tipoventa')==5)
				{
					$venta->convenio='1';
				}
				else
				{
					$venta->convenio='0';
				}

				$venta->update();
				Session::flash('venta_creada', 'HHF-00'.$request->get('tipoventa').$id);
				Session::flash('valorventa', number_format($request->get('valorventa')));
				Session::flash('efectivo', number_format($request->get('valor')));
				Session::flash('fecha_nueva',$mytime=Carbon::now('America/Bogota') );
				Session::flash('fecha_cupo',$reset );
				Session::flash('cambio', number_format($request->get('valor') - $request->get('valorventa') ));
				return response()->json(["mensaje"=>"success"] ); 


				 
			}
  
			   
		   }
					   break;
				   
				   default:
				   $venta=Ventas::findOrFail($id);
				   $venta->valorventa=$request->get('valorventa');
				   $venta->idcliente=$request->get('cliente');
				   $venta->subtotal=$request->get('subtotal');
				   $venta->utilidades=$request->get('utilidad2')-$request->get('descuento');
				   $mytime=Carbon::now('America/Bogota');
				   $venta->fecha=$mytime->toDateTimeString();
				   $venta->importeventa=$request->get('valor');
				   $venta->estado='1';
				   $venta->idtipoventa=$request->get('tipoventa');
				   $venta->descuento=$request->get('descuento');
				   $venta->comision=$request->get('comis');
				   if($request->get('tipoventa')==5)
				   {
					   $venta->convenio='1';
				   }
				   else
				   {
					   $venta->convenio='0';
				   }
				   $venta->update();

				  
				   Session::flash('venta_creada', 'HHF-00'.$request->get('tipoventa').$id);
				   Session::flash('valorventa', number_format($request->get('valorventa')));
				   Session::flash('efectivo', number_format($request->get('valor')));
				   Session::flash('cambio', number_format($request->get('valor') - $request->get('valorventa') ));
				   return response()->json(["mensaje"=>"success"] ); 
					   break;
			   }
			  
			    //return response()->json(["mensaje"=>$request->get('utilidad')-$request->get('descuento')] );
				//exit;
      
   }
	
	}

                              
		   
		   
		   }
		   else
		   {
 return Redirect::to('peticion/login')->with('mensaje','Debes ingresar tu cuenta para acceder');
		   }


	  
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
							
						
	 return view("peticion.ventas.ajaxproductos",["articulos"=>$articulos,"id"=>$id,"ultimaventa"=>$ultimaventa]);
	 
	 
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
							
		return view("peticion.ventas.busquedaproductos",["medicamento"=>$medicamento]);			
	 
	 
	 
 }
  public function detalleajax(Request $request)
 {
	 
	$ultimaventa=DB::table('venta as v')
			              ->where('v.idusuario','=',$request->session()->get('id'))
						  ->orderby('v.idventa','desc')
						  ->select('v.idventa','v.estado')
						  ->first();
						 
						  
						  /*PRODUCTOS ASOCIADOS EN ESTA FACTURA*/
		$detalleventa=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select('p.descripcionproducto','p.codigobarra1','pr.nombreproveedor','d.cantidad','d.valor','d.subtotal','p.idproducto','d.iddetalleventa')
		                  ->where('d.idventa','=',$ultimaventa->idventa)
						  ->get();
		$sumarray=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalleventa) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'),DB::raw('sum(d.comision) as comi'))
		                  ->where('d.idventa','=',$ultimaventa->idventa)
						  ->first();
		return view("peticion.ventas.detalleproducto",["ultimaventa"=>$ultimaventa,"detalleventa"=>$detalleventa,"sumarray"=>$sumarray]);			
	 
	 
	 
 }
 public function ventajax(Request $request)
 {
	 
	$clientes=DB::table('clientes')->get();
	$tipoventa=DB::table('tipoventa as v')
					   ->select('v.idtipoventa','v.desctipoventa')
					   ->get();
	$ultimaventa=DB::table('venta as v')
			              ->where('v.idusuario','=',$request->session()->get('id'))
						  ->orderby('v.idventa','desc')
						  ->select('v.idventa','v.estado')
						  ->first();
	$sumarray=DB::table('detalleventa as d')
		                  ->join('venta as v','d.idventa','=','v.idventa')
						  ->join('producto as p','d.idproducto','=','p.idproducto')
						  ->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
						  ->select(DB::raw('sum(cantidad) as cant'),DB::raw('count(d.iddetalleventa) as detalle'),DB::raw('sum(d.valor) as val'),DB::raw('sum(d.subtotal) as sub'),DB::raw('sum(d.utilidad) as utilidad'),DB::raw('sum(d.comision) as comi'))
		                  ->where('d.idventa','=',$ultimaventa->idventa)
						  ->first();
		
		return view("peticion.ventas.detalleventa",["clientes"=>$clientes,"tipoventa"=>$tipoventa,"sumarray"=>$sumarray,"ultimaventa"=>$ultimaventa]);			
	 
	 
	 
 }
 public function clientesbusqueda(Request $request, $id)
 {
	  $ultimaventa=DB::table('venta as v')
			              ->where('v.idusuario','=',$request->session()->get('id'))
						  ->orderby('v.idventa','desc')
						  ->select('v.idventa','v.estado')
						  ->first();
	 $clientes=DB::table('clientes as c')
	                   ->where('c.cedulacliente','=',$id)
					   ->select('c.idcliente',DB::raw('CONCAT(c.nombrecliente," ",c.apellidocliente ) as nombrecompleto'))
					   ->first();
		if(sizeof($clientes)==0)
		{
			return response()->json(["mensaje"=>"desconocido"] );
			
		}
					$idcliente=$clientes->idcliente;
		return response()->json(["mensaje"=>$clientes->idcliente, "nombre"=>$clientes->nombrecompleto] );
	 //return view("peticion.ventas.clientesearch",["clientes"=>$clientes]);
	 
	 
	 
	 
	 
	 
 }

 }
