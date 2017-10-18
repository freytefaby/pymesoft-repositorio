<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>
Reporte mes
</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="estilos.css" />
<link rel="shortcut icon" href="/favicon.ico" />
 
 {!! Html::style('assets/public/css/bootstrap.min.css') !!}
 
<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
 
<body>
    
   <div style="width:200px" align="center">
<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>
{{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}<br>
		===============================
		<div class="width:200px" align="center">
	  Fecha inicio <br>{{$ini}}<br>
	  Fecha Final <br>{{$end}}<br>
	   </div>

	===============================<br>
Reporte Mes<br>
===============================<br>
</div>
<div style="width:200px" align="left">
Total ventas: {{number_format($sumarray->valorventa - $sumanota->valnota  - $sumacompra->valcompra - $sumadev->devolucion - $sumagasto->gasto + $sumaingreso->ingreso )}}<br>
Subtotal: {{number_format($sumarray->subtotal  - $sumanota->sub - $sumacompra->subcompra -  $sumadev->sub - $sumagasto->gasto + $sumaingreso->ingreso)}}<br>
Utilidad: {{number_format($sumarray->utilidades + $sumaingreso->utilidad  - $sumagasto->gasto - $sumadev->utilidad - $sumanota->utilidad)}}<br>
Gastos: {{number_format($sumagasto->gasto)}}<br>
Otros ingresos: {{number_format($sumaingreso->ingreso)}}<br>
Compras: {{number_format($sumacompra->valcompra)}}<br>
</div>

<div style="width:200px" align="center">
===============================<br>
Detalle de venta vendedores<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Usuario</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($ventausuarios as $user )

<tr><td>{{$user->user}}</td><td>{{number_format($user->numventas)}}</td><td align="center">{{number_format($user->valorventa)}}</td></tr>

@endforeach
</table>
</div>
<div style="width:200px" align="center">
===============================<br>
Tipos de venta<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Tipo</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($tiposventa as $tip )

<tr><td>{{$tip->desctipoventa}}</td>
	<td>{{number_format($tip->numventas)}}</td>
	<td>{{number_format($tip->valorventa)}}</td>
</tr>

@endforeach
</table>




</div>
<div style="width:200px"  align="center">
===============================<br>
Devoluciones<br>
===============================
</div>
<div style="width:200px" align="left">
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




</div>
<div style="width:200px"  align="center">
===============================<br>
Gastos<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Proveedor</td><td>Valor</td></tr>
@foreach($gasto as $g)

<tr><td>{{$g->proveedorgasto}}</td><td>{{number_format($g->valorgasto)}}</td></tr>

@endforeach
</table>




</div>
<div style="width:200px"  align="center">
===============================<br>
Ingresos<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Proveedor</td><td>Valor</td></tr>
@foreach($ingreso as $g)

<tr><td>{{$g->proveedoringreso}}</td><td>{{number_format($g->valoringreso)}}</td></tr>

@endforeach
</table>




</div>
<div style="width:200px"  align="center">
===============================<br>
Notas a credito<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>usuario</td><td>nota</td><td>Valor</td></tr>
@foreach($notacredito as $not)

<tr><td>{{$not->user}}</td><td>HHFNC-000{{$not->idnotacredito}}</td><td>{{number_format($not->valornotacredito)}}</td></tr>

@endforeach
</table>




</div>


<div style="width:200px"  align="center">
===============================</div>


</body>
</html>