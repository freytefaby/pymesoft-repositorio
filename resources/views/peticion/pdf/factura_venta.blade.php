<!DOCTYPE html>
 
<html lang="es">
 
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>@foreach($ventas as $vent)
HHF-00{{$vent->idtipoventa}}{{$vent->idventa}}
@endforeach</title>

<link rel="stylesheet" href="estilosdds.css" />
<link rel="shortcut icon" href="/favicon.ico" />
<style>
    <?php include(public_path().'/css/bootstrap.min.css');?>
</style>
 
<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
 
<body>
    
   <div style="width:200px" align="center">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
<font size="13px" face="sans-serif" style="italic"  > {{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}<br>
	   Factura simplificada<br>
	   {{fecha($vent->fecha)}}
    @foreach($ventas as $vent)<br>
	***************************************************************<br>
Fac: HHF-00{{$vent->idtipoventa}}{{$vent->idventa}}<br>
***************************************************************<br></font>
</div>

@endforeach
<div class="row" style="width:240px" align="center">
<p align="left"><font size="13px" face="sans-serif" style="italic"  >
<table >
<tr>
<th>Producto</th>
<th>Cant</th>
<th>Valor</th>


</tr>
@foreach($detalleventa as $detail)
<tr>
<td>
@if(strlen($detail->descripcionproducto)>40)
<font font size="13px" face="sans-serif" style="italic">{{mb_strtolower(substr($detail->descripcionproducto,0,40))}}</font> 
@else 
<font font size="13px" face="sans-serif" style="italic">{{mb_strtolower($detail->descripcionproducto)}} </font> 
@endif
</td>
<td>{{$detail->cantidad}}</td>
<td>{{number_format($detail->subtotal)}}</td>
</tr>
</font>
@endforeach

</table>
<font font size="13px" face="sans-serif" style="italic">***************************************************************</font>
</div>

<div style="width:200px" align="right">
<font font size="13px" face="sans-serif" style="italic">
No. productos: {{$sumarray->detalle}}<br>
@foreach($ventas as $vent)
Recargo Iva:{{number_format($vent->valorventa-$vent->subtotal)}} <br>
Subtotal: {{number_format($vent->subtotal)}}<br>
Total a pagar: {{number_format($vent->valorventa)}}<br>
Recibido: {{number_format($vent->importeventa)}}<br>
Cambio: {{number_format($vent->importeventa-$vent->valorventa)}}
@endforeach
</font>


</div>
<div style="width:200px" align="center">
<font font size="13px" face="sans-serif" style="italic">***************************************************************
 @foreach($ventas as $vent)
Vendedor:{{$vent->nombreusuario}} <br>
Cliente:{{$vent->nombrecliente}}
@endforeach
***************************************************************<br>
MUCHAS GRACIAS POR TU COMPRA, TE ESPERAMOS NUEVAMENTE!!
<br>
***************************************************************
</font>
</div>
</body>
</html>