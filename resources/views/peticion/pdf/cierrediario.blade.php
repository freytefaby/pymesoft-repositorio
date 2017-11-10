<!DOCTYPE html>
<html lang="es">

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>HHCD-00{{$exist->idusuario}}{{$exist->idcierrediario}} </title>
<link rel="shortcut icon" href="/favicon.ico" />
<style>
  
   html {
 margin: 0;
}
body {
 font-family: "sans-serif", serif;
 margin: 0mm 0mm 0mm 4mm;
}
</style>

<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
<body>

 <div style="width:250px" align="center">
{{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}
	<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">======================================= <br>
	  Comprobante de cierre. <br>
	  =======================================<br>
	  {{fecha($exist->fechacierre)}}<br>
	  Generado: <br>
	  {{$exist->fecha}} <br>
	  No cierre: HHCD-00{{$exist->idusuario}}{{$exist->idcierrediario}}<br>
	  =======================================<br>
	  Detalle de cierre.<br>
	  =======================================
</p>
<p align="left" style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">
Total ventas: {{number_format($exist->valorventa)}}<br>
Subtotal: {{number_format($exist->subtotal)}}<br>
Utilidad diaria: {{number_format($exist->utilidades)}}<br>
Gastos: {{number_format($exist->gastos)}}<br>
Base de caja: {{number_format($exist->base)}}<br>
Recogida: {{number_format($exist->recogida)}}
</p>
<p style="padding: 0cm 0cm 0cm 0cm; margin: 0mm 0mm 0mm 0mm;">
@if(count($ventausuarios)>0)
=======================================<br>
Detalle ventas vendedores<br>
=======================================
<table >
<tr ><td>Usuario</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($ventausuarios as $vent)

<tr><td>{{$vent->user}}</td><td>{{number_format($vent->valorventa)}}</td><td align="center">{{$vent->numventas}}</td></tr>

@endforeach
</table>
@endif

@if(count($tiposventa)>0)
=======================================<br>
Tipos de venta <br>
=======================================
<table >
<tr><td>Tipo</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($tiposventa as $tp)

<tr><td>{{$tp->desctipoventa}}</td><td>{{number_format($tp->valorventa)}}</td><td align="center">{{$tp->numventas}}</td></tr>

@endforeach
</table>
@endif

@if(count($devoluciones)>0)
=======================================<br>
Devoluciones <br>
=======================================
<table >
<tr ><td>Usuario</td><td>Valor</td><td>No.dev</td></tr>
@foreach($devoluciones as $dev)

<tr><td>{{$dev->user}}</td><td>{{number_format($dev->valordevolucion)}}</td><td align="center">HHFD-00{{$dev->idventa}}{{$dev->iddevolucioncliente}}</td></tr>

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
Otros Ingresos <br>
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
Notas a credito<br>
=======================================
<table >
<tr ><td>usuario</td><td>nota</td><td>Valor</td></tr>
@foreach($notacredito as $not)

<tr><td>{{$not->user}}</td><td>HHFNC-000{{$not->idnotacredito}}</td><td>{{number_format($not->valornotacredito)}}</td></tr>

@endforeach
</table>
@endif

@if(count($compra)>0)
=======================================<br>
Compras <br>
=======================================
<table >
<tr ><td>Usuario</td><td>Compra</td><td>No.</td></tr>
@foreach($compra as $c)

<tr><td>{{$c->user}}</td><td>{{number_format($c->valorcompra)}}</td><td align="center">HHFC-000{{$c->idcompra}}</td></tr>

@endforeach
</table>
@endif

@if(count($abonos)>0)
=======================================<br>
Abonos <br>
=======================================
<table>
<tr>
	<td>Cliente</td>
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

=======================================<br>
Recogida<br>
=======================================</p>
<p align="align-justify">
@if($exist->recogida < $exist->valorventa)
	Faltante de . {{number_format($exist->valorventa - $exist->recogida)}}
@else
	Sobrante de . {{number_format($exist->recogida - $exist->valorventa)}}
@endif
<br>
Valor a retirar: {{number_format($exist->recogida)}}<br>
<font color="red">El valor final de la recogida se ha tenidoe en cuenta los gastos y otros ingresos que se hayan generado.</font>
</P>
	




</body>
</html>