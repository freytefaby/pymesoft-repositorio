<!DOCTYPE html>
<html lang="es">

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Reporte Mensual</title>
<link rel="shortcut icon" href="/favicon.ico" />
<style>
   <?php include(public_path().'/css/bootstrap.min.css');?>
   html {
 margin: 0;
}
body {
 font-family: "sans-serif", serif;
 margin: 0mm 0mm 0mm 8mm;
}
</style>

<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
<body>
<?php $valnotacredito=0; $totaldevolucion=0; $valingreso=0; $utilingreso=0; ?>
														@foreach($notacredito as $not )
														<?php $valnotacredito=$valnotacredito + $not->valornotacredito; ?>
														@endforeach
														@foreach($devoluciones as $dev )
                                                        <?php $totaldevolucion=$totaldevolucion + $dev->valordevolucion ?>
														@endforeach
														@foreach($ingreso as $g )
														<?php $valingreso= $valingreso+$g->valoringreso;  $utilingreso=$utilingreso+$g->utilidadingreso; ?>
														@endforeach
														<?php $contabono=0; $totalabono=0; $utilidadabono=0; ?>
														@foreach($abonos as $ab )
														<?php $contabono=$contabono+1; $totalabono=$totalabono+$ab->valorabono; $utilidadabono=$utilidadabono+$ab->utilidad_abono ?>
														@endforeach
														<?php $notascredito=0; $utilidadesnot=0; ?>
														@foreach($notacredito as $not )
														<?php $notascredito=$notascredito+$not->valornotacredito; $utilidadesnot=$utilidadesnot+$not->utilidades;  ?>
														@endforeach
														<?php $compras=0; ?>
														@foreach($compra as $c )
														<?php $compras=$compras+$c->valorcompra; ?>
														@endforeach
														<?php $gasto1=0; ?>
														@foreach($gasto as $g )
														<?php $gasto1=$gasto1+$g->valorgasto; ?>
														@endforeach
														<?php $compradev=0; ?>
														@foreach($devolucionescompras as $devcomp )
														<?php $compradev=$compradev+$devcomp->valordevolucion; ?>
														@endforeach
						
 <div style="width:250px" align="center">
{{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}<br>
	<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">======================================= <br>
	Fecha inicio <br>{{$ini}}<br>
	  Fecha Final <br>{{$end}}<br>
	  =======================================<br>
	  Reporte Ventas <br>
	  =======================================<br>
	  Venta General: {{number_format($sumarray->valorventa)}} <br>
=======================================</p>
<p align="left" style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;" >

- Descuentos: {{number_format($sumarray->descuentos)}}<br>
- Devoluciones: {{number_format($totaldevolucion)}}<br>
- Notas a credito: {{number_format($notascredito)}}<br>
- Gastos: {{number_format($gasto1)}}<br>
- Compras: {{number_format($compras)}} <br>
- Convenios: {{number_format($convenios->valorventa)}}<br>
+ Ingresos: {{number_format($valingreso)}}<br>
+ Abonos: {{number_format($totalabono)}}<br>
+ Devoluciones por compra: {{number_format($compradev)}}<br>
TOTAL EN VENTAS: {{number_format($sumarray->valorventa - $sumarray->descuentos - $totaldevolucion   - $notascredito - $convenios->valorventa -$compras - $gasto1 + $valingreso + $compradev + $totalabono)}}
</P>
<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">======================================= <br>
Subtotal: {{number_format($sumarray->subtotal)}} <br>
=======================================</p>
<p align="left" style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;" >
- Devoluciones: {{number_format($sumadev->subdev)}}<br>
- Convenios: {{number_format($convenios->subtotal)}}<br>
SUBTOTAL: {{number_format($sumarray->subtotal - $sumadev->subdev - $convenios->subtotal)}}
</p>
<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">======================================= <br>
Utilidades: {{number_format($sumarray->utilidades)}} <br>
=======================================</p>
<p align="left" style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;" >
- Descuentos: {{number_format($sumarray->descuentos)}}<br>
- Gastos: {{number_format($gasto1)}}<br>
- Comisiones de venta: {{number_format($sumarray->com)}}<br>
- Devoluciones: {{number_format($sumadev->utilidadsuma)}}<br>
- Convenios: {{number_format($convenios->utilidades)}}<br>
- Notas a credito: {{number_format($utilidadesnot)}}<br>
+ Comisiones devolucion: {{number_format($sumadev->com_dev)}}<br>
+ Utilidad otros ingresos: {{number_format($utilingreso)}}<br>
+ Utilidad por abonos: {{number_format($utilidadabono)}}<br>
UTILIDADES: {{number_format($sumarray->utilidades - $sumarray->descuentos - $sumarray->com  - $sumadev->utilidadsuma - $utilidadesnot - $gasto1 -  $convenios->utilidades  + $sumadev->com_dev + $utilingreso +  $utilidadabono)}}
</p>

<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">
@if(count($ventausuarios)>0)
======================================= <br>
Detalle de venta <br>
=======================================
<table >
<tr ><td>Usuario</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($ventausuarios as $user )

<tr><td>{{$user->user}}</td><td>{{number_format($user->numventas)}}</td><td align="center">{{number_format($user->valorventa)}}</td></tr>

@endforeach
</table>
@endif


@if(count($tiposventa)>0)
=======================================<br>
Tipos de venta<br>
=======================================
<table >
<tr ><td>Tipo</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($tiposventa as $tip )

<tr><td>{{$tip->desctipoventa}}</td>
	<td>{{number_format($tip->numventas)}}</td>
	<td>{{number_format($tip->valorventa)}}</td>
</tr>

@endforeach
</table>
@endif


@if(count($devoluciones)>0)
=======================================<br>
Devoluciones <br>
=======================================
<table >
<tr ><td>Usuario</td><td>No.dev</td><td>Valor</td></tr>
@foreach($devoluciones as $dev )
														
														<tr>
														
														<td>{{$dev->user}}</td>
														<td>HHFD-00{{$dev->idventa}}{{$dev->iddevolucioncliente}}</td>
														<td>{{number_format($dev->valordevolucion)}}</td>
														</tr>
														
@endforeach
</table>
@endif



@if(count($gasto)>0)
=======================================<br>
Gastos <br>
=======================================
<table >
<tr ><td>Proveedor</td><td>Valor</td></tr>
@foreach($gasto as $g)

<tr><td>{{$g->proveedorgasto}}</td><td>{{number_format($g->valorgasto)}}</td></tr>

@endforeach
</table>
@endif





@if(count($ingreso)>0)
=======================================<br>
Ingresos <br>
=======================================
<table >
<tr ><td>Proveedor</td><td>Valor</td></tr>
@foreach($ingreso as $g)

<tr><td>{{$g->proveedoringreso}}</td><td>{{number_format($g->valoringreso)}}</td></tr>

@endforeach
</table>
@endif


@if(count($notacredito)>0)
=======================================<br>
Notas a credito <br>
=======================================
<table >
<tr ><td>usuario</td><td>nota</td><td>Valor</td></tr>
@foreach($notacredito as $not)

<tr><td>{{$not->user}}</td><td>HHFNC-000{{$not->idnotacredito}}</td><td>{{number_format($not->valornotacredito)}}</td></tr>

@endforeach
</table>
@endif




@if(count($abonos)>0)
=======================================<br>
Abonos <br>
=======================================
<table>
<tr>
	<td>Tipo</td>
    <td>Abono</td>
</tr>
@foreach($abonos as $ab )
<tr>
      <td>Convenio</td>
	  <td>{{number_format($ab->valorabono)}}</td>
</tr>
@endforeach
</table>
@endif




@if(count($devolucionescompras)>0)
=======================================<br>
Devoluciones compras <br>
=======================================
<table >
														<tr>
														<td> Usuarios</td>
														<td> No facturas</td>
														<td> Ventas</td>
													
														
														</tr>
														
														@foreach($devolucionescompras as $devcomp )
														
														<tr>
														
														<td>{{$devcomp->user}}</td>
														<td>HHFCD-000{{$devcomp->iddevolucioncompra}}</td>
														<td>{{number_format($devcomp->valordevolucion)}}</td>
														</tr>
														
														
														@endforeach
														
														
														</table>
														@endif



	

	




</body>
</html>