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
use hhfarm\Abono;
use hhfarm\DetalleConvenio;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Session;
class ConvenioController extends Controller
{
    public function __construct()
	{
   	
	}
	public function index(Request $request)
	{
		
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {

if($request)
		{
			
			
			 $convenio=DB::table('venta as v')
	                   ->join('clientes as c','v.idcliente','=','c.idcliente')
					   ->join('usuarios as u','u.idusuario','=','v.idusuario')
					   ->join('cupo as cu','cu.idcliente','=','c.idcliente')
					   ->select(DB::raw('sum(v.valorventa) as ventas'),'c.nombrecliente','cu.max_credito','v.fecha','cu.dias_credito','c.idcliente')
					   ->where('v.idtipoventa','=',5)
					   ->where('v.convenio','=',1)
					   ->groupby('v.idcliente')
					   ->orderby('v.fecha','asc')
					   ->get();
			return view('peticion.convenio.index',["convenio"=>$convenio]);
			
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

if($request)
		{
			$query=trim($request->get('id'));
			
			 $convenio=DB::table('venta as v')
	                   ->join('clientes as c','v.idcliente','=','c.idcliente')
					   ->join('usuarios as u','u.idusuario','=','v.idusuario')
					   ->join('cupo as cu','cu.idcliente','=','c.idcliente')
					   ->select('v.valorventa','c.nombrecliente','cu.max_credito','v.fecha','cu.dias_credito','c.idcliente','V.idtipoventa','v.idventa','v.utilidades')
					   ->where('v.idtipoventa','=',5)
					   ->where('v.convenio','=',1)
					   ->where('v.idcliente','=',$query)
					   ->orderby('v.fecha','desc')
					   ->get();
			$abonos=DB::table('convenio as c')
			->where('c.idcliente','=',$query)
			->where('c.estadoconvenio','=',0)
			->first();
		  $detalle_abono=DB::table('detalle_abono as db')
		  ->join('convenio as c','c.idconvenio','=','db.idconvenio')
		  ->where('c.estadoconvenio','=',0)
		  ->where('c.idcliente','=',$query)
		  ->get();
		  $detalle_abono_anterior=DB::table('detalle_abono as db')
		  ->join('convenio as c','c.idconvenio','=','db.idconvenio')
		  ->select(DB::raw('sum(utilidad_abono) as abono'))
		  ->where('c.estadoconvenio','=',0)
		  ->where('c.idcliente','=',$query)
		  ->orderby('iddetalleabono','desc')
		  ->first();

			return view('peticion.convenio.create',["convenio"=>$convenio,"cliente"=>$request->get('id'),"abonos"=>$abonos,"detalle_abono"=>$detalle_abono,"detalle_abono_anterior"=>$detalle_abono_anterior]);
			
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

	

		$validar=DB::table('convenio as c')
		->where('c.idcliente','=',$request->get('cliente'))
		->where('c.estadoconvenio','=','0')
		->first(); 
	
	 if(sizeof($validar)>0)
	 {

		if($validar->valorconvenio == $request->get('valorconvenio') )
		{
			$c=$request->get('valorconvenio');
			$utilidad=$request->get('utilidad');
			$res=$utilidad / $c;
			$valor=$request->get('abono') * $res   ;
			echo "ENTRO EN LA PRIMERA CONDICION <BR>";
			echo "Ventas:"." ".$c."<br>";
			echo "Utilidad:"." ".$utilidad."<br>";
			echo "Porcentaje:"." ".$res."<br>";
			echo "Abono:"." ".$request->get('abono')."<br>";
			echo "Utilidad del abono:"." ".$valor."<br>";
			
		}
		else
		{
			$c=$request->get('valorconvenio') - $request->get('convenios'); // 14.500
			$utilidad=$request->get('utilidad') - $request->get('anterior'); // 5.227
			$res=$utilidad / $c;    // 0.36 %
			$valor=$request->get('abono') * $res   ; /// X 5000 = 1802
			echo "ENTRO EN LA SEGUNDA CONDICION <BR>";
			echo "Ventas:"." ".$c."<br>";
			echo "Utilidad:"." ".$utilidad."<br>";
			echo "Porcentaje:"." ".$res."<br>";
			echo "Abono:"." ".$request->get('abono')."<br>";
			echo "Utilidad del abono:"." ".$valor."<br>";
		}
	}
	$c=$request->get('valorconvenio');
	$utilidad=$request->get('utilidad');
	$res=$utilidad / $c;
	$valor=$request->get('abono') * $res   ;
	echo "SI NO EXISTE NINGUN CONVENIO <BR>";
	echo "Ventas:"." ".$c."<br>";
	echo "Utilidad:"." ".$utilidad."<br>";
	echo "Porcentaje:"." ".$res."<br>";
	echo "Abono:"." ".$request->get('abono')."<br>";
	echo "Utilidad del abono:"." ".$valor."<br>";
		EXIT;
	
		
		if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			   {

if($request)
		{




			$valor=$request->get('abono')+$request->get('convenios');
			//print_r($valor); exit;
			if($valor>$request->get('valorconvenio'))
			{
				return Redirect::to('peticion/convenio/create?id='.$request->get('cliente'))->with('mensaje','Error el valor del abono es superior al convenio');
			}

                   //SE COMPARA QUE EL VALOR DEL CONVENIO SEA IGUAL AL ABONO COMPLETO.
			if ($request->get('valorconvenio')==$valor) {

				$validar=DB::table('convenio as c')
				->where('c.idcliente','=',$request->get('cliente'))
				->where('c.estadoconvenio','=','0')
				->first();
				//SE VALIDA SI EXISTE EL CONVENIO 


				if($validar->valorconvenio == $request->get('valorconvenio') )
					{
						$c=$request->get('valorconvenio');
						$utilidad=$request->get('utilidad');
						$res=$utilidad / $c;
						$valor=$request->get('abono') * $res   ;
					}
					else
					{
						$c=$request->get('valorconvenio') - $request->get('convenios'); // 14.500
						$utilidad=$request->get('utilidad') - $request->get('anterior'); // 5.227
						$res=$utilidad / $c;    // 0.36 %
						$valor=$request->get('abono') * $res   ; /// X 5000 = 1802
	
					}
				if (count($validar)==1) 
				{
					$actualizar=Convenio::findOrFail($validar->idconvenio);
					$actualizar->valorconvenio=$request->get('valorconvenio');
					$actualizar->abono=$request->get('abono')+$validar->abono;
					$actualizar->estadoconvenio='1';
					$actualizar->utilidad_convenio=$request->get('utilidad');
					if($validar->valorconvenio <> $request->get('valorconvenio') )
					{
					$actualizar->porcentaje=$request->get('abono');
				   $actualizar->cambio_ganancia=$request->get('utilidad');
			
					}
					$actualizar->update();

					$conveniovalor=DB::table('venta as v')
					->join('clientes as c','v.idcliente','=','c.idcliente')
					->join('usuarios as u','u.idusuario','=','v.idusuario')
					->join('cupo as cu','cu.idcliente','=','c.idcliente')
					->select('v.valorventa','c.nombrecliente','cu.max_credito','v.fecha','cu.dias_credito','c.idcliente','V.idtipoventa','v.idventa')
					->where('v.idtipoventa','=',5)
					->where('v.convenio','=',1)
					->where('v.idcliente','=',$request->get('cliente'))
					->orderby('v.fecha','desc')
					->get();
					$cont=0;
					
					//print_r(sizeof($conveniovalor)); exit;
					foreach ($conveniovalor as $con ) {
						$detalleconvenio=new DetalleConvenio;
						$detalleconvenio->idconvenio=$validar->idconvenio;
						$detalleconvenio->facturascadena="HHF-005".$con->idventa;
						$detalleconvenio->valorconvenio=$con->valorventa;
						$detalleconvenio->save();
				
						$detalleconvenio=Ventas::findOrFail($con->idventa);
						$detalleconvenio->convenio='0';
						$detalleconvenio->update();
					}
				if($validar->valorconvenio == $request->get('valorconvenio') )
				{
					$c=$request->get('valorconvenio');
					$utilidad=$request->get('utilidad');
					$res=$utilidad / $c;
					$valor=$request->get('abono') * $res   ;
				}
				else
				{
					$c=$request->get('valorconvenio') - $request->get('convenios'); // 14.500
					$utilidad=$request->get('utilidad') - $request->get('anterior'); // 5.227
					$res=$utilidad / $c;    // 0.36 %
					$valor=$request->get('abono') * $res   ; /// X 5000 = 1802

				}
					
					
					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$validar->idconvenio;
					$abono->utilidad_abono=$valor;
					$abono->save();
					
				} 
				/// ES LA PRIMERA VEZ QUE VA A REALIZAR UN ABONO PERO COMPLETO.
				else {
					$convenio=new Convenio;
					$convenio->idcliente=$request->get('cliente');
					$convenio->valorconvenio=$request->get('valorconvenio');
					$convenio->fechaconvenio=$request->get('fecha_convenio');
					$convenio->estadoconvenio='1';
					$convenio->abono=$request->get('abono');
					$convenio->dias_cupo=$request->get('cupo');
					$convenio->valor_maximo=$request->get('valor_cupo');
					$convenio->utilidad_convenio=$request->get('utilidad');
					$convenio->porcentaje=$request->get('abono');
					$convenio->cambio_ganancia=$request->get('utilidad');
					$convenio->save();


					if($validar->valorconvenio == $request->get('valorconvenio') )
					{
						$c=$request->get('valorconvenio');
						$utilidad=$request->get('utilidad');
						$res=$utilidad / $c;
						$valor=$request->get('abono') * $res   ;
					}
					else
					{
						$c=$request->get('valorconvenio') - $request->get('convenios'); // 14.500
						$utilidad=$request->get('utilidad') - $request->get('anterior'); // 5.227
						$res=$utilidad / $c;    // 0.36 %
						$valor=$request->get('abono') * $res   ; /// X 5000 = 1802
	
					}


					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$convenio->idconvenio;
					$abono->utilidad_abono=$valor;
					$abono->save();

					$cont=0;
					$conveniovalor=DB::table('venta as v')
					->join('clientes as c','v.idcliente','=','c.idcliente')
					->join('usuarios as u','u.idusuario','=','v.idusuario')
					->join('cupo as cu','cu.idcliente','=','c.idcliente')
					->select('v.valorventa','c.nombrecliente','cu.max_credito','v.fecha','cu.dias_credito','c.idcliente','V.idtipoventa','v.idventa')
					->where('v.idtipoventa','=',5)
					->where('v.convenio','=',1)
					->where('v.idcliente','=',$request->get('cliente'))
					->orderby('v.fecha','desc')
					->get();
					//print_r(sizeof($conveniovalor)); exit;
					foreach ($conveniovalor as $con ) {
						$detalleconvenio=new DetalleConvenio;
						$detalleconvenio->idconvenio=$convenio->idconvenio;
						$detalleconvenio->facturascadena="HHF-005".$con->idventa;
						$detalleconvenio->valorconvenio=$con->valorventa;
						$detalleconvenio->save();
				
						$detalleconvenio=Ventas::findOrFail($con->idventa);
						$detalleconvenio->convenio='0';
						$detalleconvenio->update();
					}
				}
				
				

	
	                       
	
					
				
			
			} 
			// SE VALIDA SI VAMOS A REALIZAR ABONOS A LA DEUDA Y NO SON COMPLETOS
			else {
    
				$validar=DB::table('convenio as c')
				->where('c.idcliente','=',$request->get('cliente'))
				->where('c.estadoconvenio','=','0')
				->first();
   
				if(count($validar)==1)
				{
					$actualizar=Convenio::findOrFail($validar->idconvenio);
					$actualizar->valorconvenio=$request->get('valorconvenio');
					$actualizar->utilidad_convenio=$request->get('utilidad');
					$actualizar->abono=$request->get('abono')+$validar->abono;
					if($validar->valorconvenio <> $request->get('valorconvenio') )
					{
					$actualizar->porcentaje=$request->get('abono');
					$actualizar->cambio_ganancia=$request->get('utilidad');
			
					}
					$actualizar->update();

					if($validar->valorconvenio == $request->get('valorconvenio') )
					{
						$c=$request->get('valorconvenio');
						$utilidad=$request->get('utilidad');
						$res=$utilidad / $c;
						$valor=$request->get('abono') * $res   ;
					}
					else
					{
						$c=$request->get('valorconvenio') - $request->get('convenios'); // 14.500
						$utilidad=$request->get('utilidad') - $request->get('anterior'); // 5.227
						$res=$utilidad / $c;    // 0.36 %
						$valor=$request->get('abono') * $res   ; /// X 5000 = 1802
	
					}

					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$validar->idconvenio;
					$abono->utilidad_abono=$valor;
					$abono->save();

				}
				else
				{
					$convenio1=new Convenio;
					$convenio1->idcliente=$request->get('cliente');
					$convenio1->valorconvenio=$request->get('valorconvenio');
					$convenio1->fechaconvenio=$request->get('fecha_convenio');
					$convenio1->estadoconvenio='0';
					$convenio1->abono=$request->get('abono');
					$convenio1->dias_cupo=$request->get('cupo');
					$convenio1->valor_maximo=$request->get('valor_cupo');
					$convenio1->utilidad_convenio=$request->get('utilidad');
					$convenio1->porcentaje=$request->get('abono') ;
					$convenio1->cambio_ganancia=$request->get('utilidad') ;
					
					$convenio1->save();

					
						$c=$request->get('valorconvenio');  // 18.000
						$utilidad=$request->get('utilidad'); // 6027
						$res=$utilidad / $c;   // 0.33 %
						$valor=$request->get('abono') * $res   ;  // X 3000 = 1004
					
					
					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$convenio1->idconvenio;
					$abono->utilidad_abono=$valor;
					$abono->save();

					

				}
				
				
			}
			
			return Redirect::to('peticion/convenio');
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
	
	
 

 


 public function verconvenios()
 {
	 
	 $convenios=DB::table('convenio as v')
					   ->join('clientes as c','v.idcliente','=','c.idcliente')
					   ->where('estadoconvenio','=','1')
					   ->orderby('v.fechaconvenio','desc')
					   ->get();
	return view('peticion.convenio.pagos',["convenios"=>$convenios]);
 }


 public function show(Request $request, $id)
 {
	if($request->session()->has('id'))
	{
	  
 if($request->session()->get('perfil')==1 or $request->session()->get('perfil')==2  )
			  {

if($request)
	   {
		  
		   
		   $infoempresa=DB::table('infoempresa')
		   ->select('nombrecomercialempresa','direccionempresa','telefonoempresa','nitempresa','ciudadempresa')
		   ->first();
	
 $convenio=DB::table('detalle_convenio as dc')
			   ->join('convenio as c','c.idconvenio','=','dc.idconvenio')
			   ->join('clientes as cl','cl.idcliente','=','c.idcliente')
			   ->where('dc.idconvenio','=',$id)
			   ->first();

$consulta=DB::table('detalle_convenio as dc')
			   ->select('dc.valorconvenio','dc.facturascadena','cl.nombrecliente','dc.valorconvenio','dc.facturascadena')
			   ->join('convenio as c','c.idconvenio','=','dc.idconvenio')
			   ->join('clientes as cl','cl.idcliente','=','c.idcliente')
			   ->where('dc.idconvenio','=',$id)
			   ->ORDERBY('dc.facturascadena','asc')
			   ->get();
			   $abonos=DB::table('detalle_abono as da')
			   ->join('convenio as c','c.idconvenio','=','da.idconvenio')
			   ->where('da.idconvenio','=',$id)
			   ->get();
		 
		   return view('peticion.convenio.show',["convenio"=>$convenio,"abonos"=>$abonos,"consulta"=>$consulta]);
		   
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
 

 }
