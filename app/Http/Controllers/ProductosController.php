<?php

namespace hhfarm\Http\Controllers;

use Illuminate\Http\Request;

use hhfarm\Http\Requests;
use hhfarm\Productos;
use Illuminate\Support\Facades\Redirect;
use hhfarm\Http\Requests\ProductosFormRequest;
use hhfarm\Http\Requests\ProductosFormRequestUpdate;
use DB;
use Session;
class ProductosController extends Controller
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
			$query=trim($request->get('searchText'));
			$productos=DB::table('producto as p')
			->join('iva as i','i.idiva','=','p.idiva')
			->join('tipoproducto as t','t.idtipoproducto','=','p.idtipoproducto')
			->join('categoria as c','c.idcategoria','=','p.idcategoria')
			->join('proveedor as pr','pr.idproveedor','=','p.idproveedor')
			->select('p.descripcionproducto','p.idproducto','p.codigobarra1','c.descripcioncategoria','pr.nombreproveedor','t.descripciontipoproducto','p.stock','p.preciosugerido','p.preciocompra','i.valoriva','p.comision','p.estado','p.activo_principio')
			->where('p.descripcionproducto','Like','%'.$query.'%')
			->orwhere('p.codigobarra1','=',$query)
			->orwhere('p.codigobarra2','=',$query)
			->orwhere('p.codigobarra3','=',$query)
			->orwhere('p.codigobarra4','=',$query)
			->orderby('p.descripcionproducto','asc')
			->paginate(7);
			return view('peticion.productos.index',["productos"=>$productos,"searchText"=>$query]);
			
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
	   
  if($request->session()->get('perfil')==1  )
			   {

     $tipo=DB::table('tipoproducto')->get();
	 $categoria=DB::table('categoria')->get();
	 $proveedor=DB::table('proveedor')->get();
	 $iva=DB::table('iva')->get();
			
	  	   
	 return view('peticion.productos.create',["tipo"=>$tipo,"categoria"=>$categoria,"proveedor"=>$proveedor,"iva"=>$iva]);

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
     public function store(ProductosFormRequest $request)
   {
	if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

if($request->get('tipoproducto')==1)
	   {
		   
			   
       $producto=new Productos;
	   $producto->descripcionproducto=$request->get('producto');
	   $producto->codigobarra1=$request->get('codigobarra1');
	   $producto->codigobarra2=$request->get('codigobarra2');
	   $producto->codigobarra3=$request->get('codigobarra3');
	   $producto->codigobarra4=$request->get('codigobarra4');
	   $producto->cantidadempaque='1';
	   $producto->stock=$request->get('stock');
	   $producto->stockminimo=$request->get('stockminimo');
	   $producto->preciocompra=$request->get('preciocompra');
	   $producto->precioventa=$request->get('precioventa');
	   $producto->preciosugerido=$request->get('preciosugerido');
	   $producto->idiva=$request->get('iva');
	   $producto->idtipoproducto=$request->get('tipoproducto');
	   $producto->idcategoria=$request->get('categoria');
	   $producto->idproveedor=$request->get('proveedor');
	   $producto->estado='1';
	   $producto->comision=$request->get('comision');
	   $producto->estante=$request->get('estante');
	   $producto->entrepano=$request->get('entrepano');
	   $producto->activo_principio=$request->get('principio');
	   $producto->save();
	   return Redirect::to('peticion/productos');
			   
		   
		   
		   
	   }else{
		   
		   		   
       $producto=new Productos;
	   $producto->descripcionproducto=$request->get('producto');
	   $producto->codigobarra1=$request->get('codigobarra1');
	   $producto->codigobarra2=$request->get('codigobarra2');
	   $producto->codigobarra3=$request->get('codigobarra3');
	   $producto->codigobarra4=$request->get('codigobarra4');
	   $producto->cantidadempaque=$request->get('cantidadempaque');
	   $producto->stock=$request->get('stock');
	   $producto->stockminimo=$request->get('stockminimo');
	   $producto->preciocompra=$request->get('preciocompra');
	   $producto->precioventa=$request->get('precioventa');
	   $producto->preciosugerido=$request->get('preciosugerido');
	   $producto->idiva=$request->get('iva');
	   $producto->idtipoproducto=$request->get('tipoproducto');
	   $producto->idcategoria=$request->get('categoria');
	   $producto->idproveedor=$request->get('proveedor');
	   $producto->estado='1';
	   $producto->comision=$request->get('comision');
	   $producto->estante=$request->get('estante');
	   $producto->entrepano=$request->get('entrepano');
	   $producto->activo_principio=$request->get('principio');
	   $producto->save();
	   return Redirect::to('peticion/productos');

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
   
    
   
     public function edit(Request $request,$id)
   {
	   if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

     $tipo=DB::table('tipoproducto')->get();
	 $categoria=DB::table('categoria')->get();
	 $proveedor=DB::table('proveedor')->get();
	 $iva=DB::table('iva')->get();


 return view("peticion.productos.edit",["productos"=>Productos::findOrFail($id),"tipo"=>$tipo,"categoria"=>$categoria,"proveedor"=>$proveedor,"iva"=>$iva]); 

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
   
     public function update(ProductosFormRequestUpdate $request,$id)
	 
   {
	  if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {

if($request->get('tipoproducto')==1)
	   {
		  
 $producto=Productos::findOrFail($id);
	   $producto->descripcionproducto=$request->get('producto');
	   $producto->codigobarra1=$request->get('codigobarra1');
	   $producto->codigobarra2=$request->get('codigobarra2');
	   $producto->codigobarra3=$request->get('codigobarra3');
	   $producto->codigobarra4=$request->get('codigobarra4');
	   $producto->cantidadempaque='1';
	   $producto->stock=$request->get('stock');
	   $producto->stockminimo=$request->get('stockminimo');
	   $producto->preciocompra=$request->get('preciocompra');
	   $producto->precioventa=$request->get('precioventa');
	   $producto->preciosugerido=$request->get('preciosugerido');
	   $producto->idiva=$request->get('iva');
	   $producto->idtipoproducto=$request->get('tipoproducto');
	   $producto->idcategoria=$request->get('categoria');
	   $producto->idproveedor=$request->get('proveedor');
	   $producto->estado=$request->get('estado');
	   $producto->comision=$request->get('comision');
	   $producto->estante=$request->get('estante');
	   $producto->entrepano=$request->get('entrepano');
	   $producto->activo_principio=$request->get('principio');
	   $producto->update();
	   return Redirect::to('peticion/productos')->with('mensaje','Producto'.$request->get('producto').' '.'Cod'.' '.$request->get('codigobarra1').' '.'fue actualizado correctamente con'.' '.$request->get('stock').' '.'Cantidades');
	   
	   }
	   else{
		   
		   if($request->get('cantidadempaque')<=0)
		   {
			    return Redirect::to('peticion/productos/'.$id.'/edit')->with('mensaje','La cantidad de empaque para un tipo de producto por cantidad no debe ser menor o igual a cero')
				                                                 ->with('producto',$request->get('producto'))
																 ->with('codigobarra1',$request->get('codigobarra1'))
																 ->with('codigobarra2',$request->get('codigobarra2'))
																 ->with('codigobarra3',$request->get('codigobarra3'))
																 ->with('codigobarra4',$request->get('codigobarra4'))
																 ->with('cantidadempaque',$request->get('cantidadempaque'))
																 ->with('stock',$request->get('stock'))
																 ->with('stockminimo',$request->get('stockminimo'))
																 ->with('preciocompra',$request->get('preciocompra'))
																 ->with('precioventa',$request->get('precioventa'))
																 ->with('preciosugerido',$request->get('preciosugerido'))
																 ->with('iva',$request->get('iva'))
																 ->with('tipoproducto',$request->get('tipoproducto'))
																 ->with('categoria',$request->get('categoria'))
																 ->with('proveedor',$request->get('proveedor'))
																 ->with('comision',$request->get('comision'))
																 ->with('estante',$request->get('estante'))
																 ->with('entrepano',$request->get('entrepano'))
																 ->with('principio',$request->get('principio'));;
		   }
		   else{
		   $producto=Productos::findOrFail($id);
	   $producto->descripcionproducto=$request->get('producto');
	   $producto->codigobarra1=$request->get('codigobarra1');
	   $producto->codigobarra2=$request->get('codigobarra2');
	   $producto->codigobarra3=$request->get('codigobarra3');
	   $producto->codigobarra4=$request->get('codigobarra4');
	   $producto->cantidadempaque=$request->get('cantidadempaque');
	   $producto->stock=$request->get('stock');
	   $producto->stockminimo=$request->get('stockminimo');
	   $producto->preciocompra=$request->get('preciocompra');
	   $producto->precioventa=$request->get('precioventa');
	   $producto->preciosugerido=$request->get('preciosugerido');
	   $producto->idiva=$request->get('iva');
	   $producto->idtipoproducto=$request->get('tipoproducto');
	   $producto->idcategoria=$request->get('categoria');
	   $producto->idproveedor=$request->get('proveedor');
	   $producto->estado=$request->get('estado');
	   $producto->comision=$request->get('comision');
	   $producto->estante=$request->get('estante');
	   $producto->entrepano=$request->get('entrepano');
	   $producto->activo_principio=$request->get('principio');
	   $producto->update();
	   return Redirect::to('peticion/productos')->with('mensaje','Producto fue actualizado correctamente');
		   
		   
	   }

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
   public function destroy(Request $request,$id)
   {
	  if($request->session()->has('id'))
	 {
	   
  if($request->session()->get('perfil')==1  )
			   {
 $producto=Productos::findOrFail($id);
     $producto->estado='0';
	 $producto->update();
	 return Redirect::to('peticion/productos');

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
   public function productosurl(Request $request,$id)
   {
	   return Redirect::to('peticion/productos/create')->with('codigobarra1',$id);
	   
   }
   
    
	}
