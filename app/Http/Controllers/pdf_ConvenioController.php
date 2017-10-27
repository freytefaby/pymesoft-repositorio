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
class Pdf_ConvenioController extends Controller
{
    public function __construct()
	{
   	
	}
	
	 public function show(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
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
                ->select('dc.valorconvenio','dc.facturascadena')
                ->join('convenio as c','c.idconvenio','=','dc.idconvenio')
                ->where('dc.idconvenio','=',$id)
                ->ORDERBY('dc.facturascadena','asc')
                ->get();
                $abonos=DB::table('detalle_abono as da')
                ->join('convenio as c','c.idconvenio','=','da.idconvenio')
                ->where('da.idconvenio','=',$id)
                ->get();


 
        $view =  \View::make('peticion.pdf.convenio', compact('infoempresa','id','convenio','consulta','abonos'))->render();
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
