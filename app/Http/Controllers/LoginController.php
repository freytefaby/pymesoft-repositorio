<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use hhfarm\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\input;
use hhfarm\Http\Requests\VentaForRequest;


use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class LoginController extends Controller
{
    public function __construct()
	{
   	
	}
	public function getIndex()
	{
		
		return view('peticion.login.index');	
		}
   public function validar_datos(Request $request)
   {
	 //  print_r(sha1($_POST["pass"])); exit;
	   $this->validate
	   (
	   $request,
	   [
	  'user'=>'required',
	  'pass'=>'required|min:7',
	   ]
	   );
	   $pass=sha1($request->get('pass'));
	                  $validar=DB::table('usuarios as u')
	                      ->join('perfil as p','p.idperfil','=','u.idperfil')
			              ->where('u.user','=',$request->get('user'))
						  ->where('u.contrasena','=',$pass)
						  ->first();
						
						  
	 if(sizeof($validar)==0)
	 {
		 return Redirect::to('peticion/login/')->with('mensaje','Datos incorrectos, por favor vuelva a validar su informacion correctamente');
	 }
	   else
	   {
		$venta=DB::table('permiso as p')
		->where('p.idrecurso','=',1)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$cliente=DB::table('permiso as p')
		->where('p.idrecurso','=',5)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$notacredito=DB::table('permiso as p')
		->where('p.idrecurso','=',11)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$devolucioncliente=DB::table('permiso as p')
		->where('p.idrecurso','=',10)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$convenio=DB::table('permiso as p')
		->where('p.idrecurso','=',7)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$cupo=DB::table('permiso as p')
		->where('p.idrecurso','=',8)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$grafico=DB::table('permiso as p')
		->where('p.idrecurso','=',13)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$compras=DB::table('permiso as p')
		->where('p.idrecurso','=',6)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$sugerido=DB::table('permiso as p')
		->where('p.idrecurso','=',20)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$proveedores=DB::table('permiso as p')
		->where('p.idrecurso','=',23)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$iva=DB::table('permiso as p')
		->where('p.idrecurso','=',17)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$devolucioncompra=DB::table('permiso as p')
		->where('p.idrecurso','=',9)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$laboratorio=DB::table('permiso as p')
		->where('p.idrecurso','=',16)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$producto=DB::table('permiso as p')
		->where('p.idrecurso','=',22)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$categoria=DB::table('permiso as p')
		->where('p.idrecurso','=',3)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$movimiento=DB::table('permiso as p')
		->where('p.idrecurso','=',18)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$empresa=DB::table('permiso as p')
		->where('p.idrecurso','=',14)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$usuario=DB::table('permiso as p')
		->where('p.idrecurso','=',24)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$permiso=DB::table('permiso as p')
		->where('p.idrecurso','=',21)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$cierre=DB::table('permiso as p')
		->where('p.idrecurso','=',4)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$mes=DB::table('permiso as p')
		->where('p.idrecurso','=',19)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$base=DB::table('permiso as p')
		->where('p.idrecurso','=',2)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$gasto=DB::table('permiso as p')
		->where('p.idrecurso','=',12)
		->where('p.idrol','=',$validar->idperfil)
		->first();
		$ingreso=DB::table('permiso as p')
		->where('p.idrecurso','=',15)
		->where('p.idrol','=',$validar->idperfil)
		->first();

		  $request->session()->put('id',$validar->idusuario);
		  $request->session()->put('perfil',$validar->idperfil);
		  $request->session()->put('user',$validar->user);
		  $request->session()->put('img',$validar->imagen);
		  if(count($venta)==0){$request->session()->put('venta','0');}else{$request->session()->put('venta',$venta->leer);}
		  if(count($cliente)==0){$request->session()->put('cliente','0');}else{$request->session()->put('cliente',$cliente->leer);}
		  if(count($notacredito)==0){$request->session()->put('nota','0');}else{$request->session()->put('nota',$notacredito->leer);}
	      if(count($devolucioncliente)==0){$request->session()->put('devolucioncliente','0');}else{$request->session()->put('devolucioncliente',$devolucioncliente->leer);}
		  if(count($convenio)==0){$request->session()->put('convenio','0');}else{$request->session()->put('convenio',$convenio->leer);}
		  if(count($cupo)==0){$request->session()->put('cupo','0');}else{$request->session()->put('cupo',$cupo->leer);}
		  if(count($grafico)==0){$request->session()->put('grafico','0');}else{$request->session()->put('grafico',$grafico->leer);}
		  if(count($compras)==0){$request->session()->put('compra','0');}else{$request->session()->put('compra',$compras->leer);}
		  if(count($sugerido)==0){$request->session()->put('sugerido','0');}else{$request->session()->put('sugerido',$sugerido->leer);}
		  if(count($proveedores)==0){$request->session()->put('proveedores','0');}else{$request->session()->put('proveedores',$proveedores->leer);}
		  if(count($iva)==0){$request->session()->put('iva','0');}else{$request->session()->put('iva',$iva->leer);}
		  if(count($devolucioncompra)==0){$request->session()->put('devolucioncompra','0');}else{$request->session()->put('devolucioncompra',$devolucioncompra->leer);} 
		  if(count($laboratorio)==0){$request->session()->put('laboratorio','0');}else{$request->session()->put('laboratorio',$laboratorio->leer);} 
		  if(count($producto)==0){$request->session()->put('producto1','0');}else{$request->session()->put('producto1',$producto->leer);} 
		  if(count($categoria)==0){$request->session()->put('categoria','0');}else{$request->session()->put('categoria',$categoria->leer);} 
		  if(count($movimiento)==0){$request->session()->put('movimiento','0');}else{$request->session()->put('movimiento',$movimiento->leer);}
		  if(count($empresa)==0){$request->session()->put('empresa','0');}else{$request->session()->put('empresa',$empresa->leer);}  
		  if(count($usuario)==0){$request->session()->put('usuario','0');}else{$request->session()->put('usuario',$usuario->leer);}  
		  if(count($permiso)==0){$request->session()->put('permiso','0');}else{$request->session()->put('permiso',$permiso->leer);} 
		  if(count($cierre)==0){$request->session()->put('cierre','0');}else{$request->session()->put('cierre',$cierre->leer);}  
		  if(count($mes)==0){$request->session()->put('mes','0');}else{$request->session()->put('mes',$mes->leer);}  
		  if(count($base)==0){$request->session()->put('base','0');}else{$request->session()->put('base',$base->leer);} 
		  if(count($gasto)==0){$request->session()->put('gasto','0');}else{$request->session()->put('gasto',$gasto->leer);} 
		  if(count($ingreso)==0){$request->session()->put('ingreso','0');}else{$request->session()->put('ingreso',$gasto->leer);} 
		   return Redirect::to('peticion/ventas');
	   }
	   
   }
   public function salir(Request $request)
   {
	  $request->session()->flush();
	  return Redirect::to('peticion/login');
   }
	}
	

