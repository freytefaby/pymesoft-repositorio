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
					   ->select('v.valorventa','c.nombrecliente','cu.max_credito','v.fecha','cu.dias_credito','c.idcliente','V.idtipoventa','v.idventa')
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

			return view('peticion.convenio.create',["convenio"=>$convenio,"cliente"=>$request->get('id'),"abonos"=>$abonos,"detalle_abono"=>$detalle_abono]);
			
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


			if ($request->get('valorconvenio')==$valor) {

				$validar=DB::table('convenio as c')
				->where('c.idcliente','=',$request->get('cliente'))
				->where('c.estadoconvenio','=','0')
				->first();
				if (count($validar)==1) 
				{
					$actualizar=Convenio::findOrFail($validar->idconvenio);
					$actualizar->abono=$request->get('abono')+$validar->abono;
					$actualizar->estadoconvenio='1';
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
					
				
					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$validar->idconvenio;
					$abono->save();
					
				} else {
					$convenio=new Convenio;
					$convenio->idcliente=$request->get('cliente');
					$convenio->valorconvenio=$request->get('valorconvenio');
					$convenio->fechaconvenio=$request->get('fecha_convenio');
					$convenio->estadoconvenio='1';
					$convenio->abono=$request->get('abono');
					$convenio->save();


					
					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$convenio->idconvenio;
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
			
			else {
    
				$validar=DB::table('convenio as c')
				->where('c.idcliente','=',$request->get('cliente'))
				->where('c.estadoconvenio','=','0')
				->first();
   
				if(count($validar)==1)
				{
					$actualizar=Convenio::findOrFail($validar->idconvenio);
					$actualizar->abono=$request->get('abono')+$validar->abono;
					$actualizar->update();


					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$validar->idconvenio;
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
					$convenio1->save();

					$abono=new Abono;
					$abono->valorabono=$request->get('abono');
					$mytime= Carbon::now('America/Bogota');
					$abono->fecha_abono=$mytime->toDateTimeString();
					$abono->idcliente=$request->get('cliente');
					$abono->idconvenio=$convenio1->idconvenio;
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
	
	
 

 


 public function cargausuarioconvenio(Request $request, $id)
 {
	 
	 $cliente=DB::table('venta as v')
	                   ->join('clientes as c','v.idcliente','=','c.idcliente')
					   ->join('usuarios as u','u.idusuario','=','v.idusuario')
	                   ->where('c.cedulacliente','=',$id)
					   ->where('v.idtipoventa','=',5)
					   ->where('v.convenio','=',1)
					   ->get();
	return view('peticion.convenio.tabladetalle',["cliente"=>$cliente]);
 }
 public function agregar(Request $request)
 {
	 $cont=0;

	 
	  while($cont < count($_GET["convenio"]))
	   {  
	    DB::update('update venta set convenio = ? where idventa = ?',['0',$_GET["convenio"][$cont]]);
		$cont=$cont+1;
		   
	   }
 }
 public function show()
 {
	 return "hola";
 }

 }
