<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>Sugerido</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="estilos.css" />
<link rel="shortcut icon" href="/favicon.ico" />
 
 {!! Html::style('assets/public/css/bootstrap.min.css') !!}
 
<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
 
<body>
    
   <div style="width:200px" align="center">
<font size="13px" face="sans-serif" style="italic"  > {{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}<br>
	   Productos de alta rotaci&oacute;n
   <br>
===============================<br>
</font>
</div>

<div style="width:200px" align="center">
<font size="13px" face="sans-serif" style="italic"  > 
<table class="table">

<tr>
<th>Producto</th>
<th>Cant</th>
<th>Valor</th>

</tr>
<p align="left">
 <?php $resultado=0; $cont=0; ?>
@foreach($consulta as $con)
 <?php $resultado=$resultado+$con->costo; $cont=$cont+1; ?>
<tr>
<td>{{strtolower($con->descripcionproducto)}}</td>
<td>{{$con->cant / $con->ventas}}</td>
<td>${{number_format($con->costo )}}</td>
</tr>
@endforeach
</table></p><br>

===============================
</font>
</div>
<div style="width:200px" align="right">
<font size="13px" face="sans-serif" style="italic"  > 
No. productos: <?php echo $cont ?> <br>
Costo compra: $<?php echo number_format($resultado) ?>
</font>


</font>
</div>

</body>
</html>