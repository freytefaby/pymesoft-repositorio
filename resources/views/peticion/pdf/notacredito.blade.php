<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>@foreach($nota as $not)
HHFNC-000{{$not->idnotacredito}}
@endforeach</title>
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
	   Factura simplificada<BR>
	    {{fecha($not->fecha)}}<BR>
		===============================<br>
		@foreach($nota as $not)
       Not: HHFNC-000{{$not->idnotacredito}}
        @endforeach
		===============================<br>
</div>
<div style="width:200px" align="center">
<table class="table">
<tr>
<th>Producto</th>
<th>Cant</th>
<th>Valor</th>


</tr>
@foreach($detallenota as $detail)
<tr>
<td>{{$detail->descripcionproducto}}</td>
<td>{{$detail->cantidad}}</td>
<td>{{number_format($detail->valor)}}</td>
</tr>
@endforeach
</table>
===============================
</div>
<div style="width:200px" align="right">
No. productos: {{$sumarray->detalle}}<br>
@foreach($nota as $not)
Valor nota : {{number_format($not->valornotacredito)}}<br>
Cliente : {{$not->nombrecliente}}</div>
<div style="width:200px" align="center">===============================</div>
<div style="width:200px">
Observacion : {{$not->observaciones}}
</div>
@endforeach

<div style="width:200px" align="center">
===============================<br>
 @foreach($nota as $not)
Vendedor:{{$not->user}} 
@endforeach
</div>

</body>
</html>