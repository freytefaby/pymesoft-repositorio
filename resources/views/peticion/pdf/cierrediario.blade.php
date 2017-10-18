<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>
HHCD-00{{$exist->idusuario}}{{$exist->idcierrediario}}
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
	   Comprobante cierre <br>{{fecha($exist->fechacierre)}}<br>
	   Generado<br>{{$exist->fecha}}
	   </div>

	===============================<br>
No cierre: HHCD-00{{$exist->idusuario}}{{$exist->idcierrediario}}<br>
===============================<br>
</div>
<div style="width:200px" align="left">
Total ventas: {{number_format($exist->valorventa)}}<br>
Subtotal: {{number_format($exist->subtotal)}}<br>
Utilidad diaria: {{number_format($exist->utilidades)}}<br>
Gastos: {{number_format($exist->gastos)}}<br>
Base de caja: {{number_format($exist->base)}}<br>
Recogida: {{$exist->recogida}}
</div>

<div style="width:200px" align="center">
===============================<br>
Detalle de venta vendedores<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Usuario</td><td>Ventas</td><td>No.ventas</td></tr>
@foreach($ventausuarios as $vent)

<tr><td>{{$vent->user}}</td><td>{{number_format($vent->valorventa)}}</td><td align="center">{{$vent->numventas}}</td></tr>

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
@foreach($tiposventa as $tp)

<tr><td>{{$tp->desctipoventa}}</td><td>{{number_format($tp->valorventa)}}</td><td align="center">{{$tp->numventas}}</td></tr>

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
<tr ><td>Usuario</td><td>Valor</td><td>No.dev</td></tr>
@foreach($devoluciones as $dev)

<tr><td>{{$dev->user}}</td><td>{{number_format($dev->valordevolucion)}}</td><td align="center">HHFD-00{{$dev->idventa}}{{$dev->iddevolucioncliente}}</td></tr>

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
===============================<br>
Compras<br>
===============================
</div>
<div style="width:200px" align="left">
<table >
<tr ><td>Usuario</td><td>Compra</td><td>No.</td></tr>
@foreach($compra as $c)

<tr><td>{{$c->user}}</td><td>{{number_format($c->valorcompra)}}</td><td align="center">HHFC-000{{$c->idcompra}}</td></tr>

@endforeach
</table>




</div>
<div style="width:200px"  align="center">
===============================</div>
<div style="width:200px" align="left">
@if($exist->recogida < $exist->valorventa)
	Faltante de . {{number_format($exist->valorventa - $exist->recogida)}}
@else
	Sobrante de . {{number_format($exist->recogida - $exist->valorventa)}}
@endif
<br>
Valor a retirar: {{number_format($exist->recogida - $exist->base - $exist->gastos)}}<br>
<font color="red">Tenga por favor en cuenta que el numero a consignar no esta teniendo en cuenta el valor de los gastos
-Los gastos solo se sumaran al valor total de las ventas en finales de mes.</font>
</div>

</body>
</html>