<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('peticion/login/index');
});
route::resource('peticion/categoria','CategoriaController');
route::resource('peticion/ventas','VentaController');
route::get('peticion/ventas/ajaxproductos/{id}','VentaController@cargaproductosajax');
route::get('peticion/ventas/ajaxsearch/{id}','VentaController@productosajax');
route::get('peticion/detalleproductos','VentaController@detalleajax');
route::get('peticion/ventajax','VentaController@ventajax');
route::post('peticion/ventas/delete/{id}','DetalleVentaController@destroy');
route::resource('peticion/ventas/detalle_venta','DetalleVentaController');
route::resource('peticion/notascredito','NotaCreditoController');
route::resource('peticion/notascredito/detalle_nota_credito','DetalleNotaCreditoController');
route::get('pdf/sugerido/carta','Pdf_SugeridoController@carta');
route::get('pdf/sugerido/ticket','Pdf_SugeridoController@ticket');
route::get('pdf/ventas/factura/{id}','Pdf_FacturaController@show');
route::get('pdf/ventas/facturacarta/{id}','Pdf_FacturaController@carta');
route::get('pdf/notacredito/factura/{id}','Pdf_NotaCreditoController@show');
route::get('pdf/compras/factura/{id}','Pdf_CompraController@show');
route::get('pdf/devoluciones/factura/{id}','Pdf_DevolucionesController@show');
route::get('pdf/devolucionescompras/factura/{id}','Pdf_DevolucionesComprasController@show');
route::get('pdf/cierre/print_cierre/{id}','Pdf_CierreDiarioController@show');
route::get('pdf/pdf_inventarioproductolaboratorio','Pdf_inventariolaboratorioproductoController@show');
route::get('pdf/pdf_reportemes','Pdf_ReporteMesController@show');
route::get('peticion/error','ErrorController@show');
route::controller('peticion/login','LoginController');
route::post('peticion/verificar_login','LoginController@validar_datos');
route::get('peticion/salir','LoginController@salir');
route::resource('peticion/clientes','ClientesController');
route::resource('peticion/productos','ProductosController');
route::get('peticion/productosurl/{id}','ProductosController@productosurl');
route::resource('peticion/infoempresa','InfoEmpresaController');
route::resource('peticion/iva','IvaController');
route::resource('peticion/proveedores','ProveedoresController');
route::resource('peticion/usuarios','UsuariosController');
route::get('peticion/restablecer/{id}','UsuariosController@restablecer');
route::post('peticion/updatecontrasena/{id}','UsuariosController@updatecontrasena');
route::resource('peticion/compras','ComprasController');
route::resource('peticion/compras/detalle_compra','DetalleCompraController');
route::resource('peticion/devoluciones','DevolucionesController');
route::resource('peticion/devoluciones/detalle_devolucion','DetalleDevolucionesController');
route::get('peticion/devolucioncliente/{id}','DevolucionesController@mostrar');
route::resource('peticion/devolucionescompras','DevolucionesComprasController');
route::resource('peticion/devoluciones/detalle_devolucioncompra','DetalleDevolucionesCompraController');
route::get('peticion/devolucioncompra/{id}','DevolucionesComprasController@mostrar');
route::resource('peticion/gasto','GastoController');
route::resource('peticion/base','BaseController');
route::resource('peticion/cierrediario','CierreController');
route::resource('peticion/inventarioproductolaboratorio','InventarioProductoLaboratorioController');
route::resource('peticion/reportemes','ReporteMesController');
route::resource('peticion/ingreso','IngresoController');
route::resource('peticion/movimientos','MovimientoController');
route::resource('peticion/graficos','GraficosController');
route::resource('peticion/sugeridos','SugeridosController');
route::get('peticion/ventas/clientes/{id}','VentaController@clientesbusqueda');
route::put('peticion/ventas/update/{id}','VentaController@update');
route::resource('peticion/sugeridos','SugeridosController');
route::resource('peticion/convenio','ConvenioController');





