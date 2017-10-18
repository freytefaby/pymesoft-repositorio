<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>
HHFD-00{{$devoluciones->idventa}}{{$devoluciones->iddevolucioncliente}}
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
	   {{fecha($devoluciones->fecha)}}<br>
	===============================<br>
Devolucion: HHFD-00{{$devoluciones->idventa}}{{$devoluciones->iddevolucioncliente}}<br>
===============================<br>
</div>

<div style="width:200px" align="center">
<table class="table">
<tr>
<th>Producto</th>
<th>Cant</th>
<th>Valor</th>
<th>Iva</th>

</tr>
@foreach($detalledevolucion as $detail)
<tr>
<td>{{$detail->descripcionproducto}}</td>
<td>{{$detail->cantidad}}</td>
<td>{{number_format($detail->subtotal)}}</td>
<td>{{number_format($detail->valor-$detail->subtotal)}}</td>
</tr>
@endforeach
</table><br>
===============================
</div>
<div style="width:200px" align="right">
No. productos: {{$sumarraydev->detalle}}<br>
Valor devolucion: {{number_format($devoluciones->valordevolucion)}}<br>
Cliente: {{$devoluciones->nombrecliente}}




</div>
<div style="width:200px" align="center">
===============================
 
Usuario:{{$devoluciones->user}} <br>

===============================<br>
Observaciones: {{$observacion->observacion}}
<br>
===============================
</div>
</body>
</html>