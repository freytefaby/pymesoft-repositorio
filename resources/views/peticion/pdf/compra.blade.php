<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>
HHFC-000{{$compras->idcompra}}
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
	   Factura simplificada<br>
	   {{fecha($compras->fecha)}}
   <br>
	===============================<br>
Mov: HHFC-000{{$compras->idcompra}}<br>
	{{$compras->numfactura}}
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
@foreach($detallecompra as $comp)
<tr>
<td>{{$comp->descripcionproducto}}</td>
<td>{{$comp->cantidad}}</td>
<td>{{number_format($comp->subtotalcompra)}}</td>
<td>{{number_format($comp->valorcompra-$comp->subtotalcompra)}}</td>
</tr>
@endforeach
</table><br>
===============================
</div>
<div style="width:200px" align="right">
No. productos: {{$sumarray->detalle}}<br>

Recargo Iva:{{number_format($compras->valorcompra-$compras->subtotalcompra)}} <br>
Subtotal: {{number_format($compras->subtotalcompra)}}<br>
Total compra: {{number_format($compras->valorcompra)}}<br>
Utilidad de compra: {{number_format($compras->utilidadcompra)}}
</div>
<div style="width:200px" align="center">
===============================
Usuario:{{$compras->user}} <br>
Proveedor:{{$compras->nombreproveedor}}
</div>

</body>
</html>