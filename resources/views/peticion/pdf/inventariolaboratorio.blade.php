<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>Inventario {{$sumarray->nombreproveedor}}</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="estilos.css" />
<link rel="shortcut icon" href="/favicon.ico" />
 
 {!! Html::style('assets/public/css/bootstrap.min.css') !!}
 
<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>
 
<body>
    
   <div style="width:200px" align="center">
<font size="13px" face="sans-serif" style="italic"  >
{{$infoempresa->nombrecomercialempresa}}<br>
	Dir: {{$infoempresa->direccionempresa}}<BR>
	Tel: {{$infoempresa->telefonoempresa}}<br>
	Nit: {{$infoempresa->nitempresa}}<br>
	Ciudad: {{$infoempresa->ciudadempresa}}<br>
	   Inventario<br>
	   {{$sumarray->nombreproveedor}}<br>
	   {{fecha($date)}}</font>
   <br>
===============================<br>
</div>

<div style="width:200px" align="center">
<table class="table">
<tr>
<th><font size="13px" face="sans-serif" style="italic"  >Producto</font></th>
<th><font size="13px" face="sans-serif" style="italic"  >Cant</font></th>
<th><font size="13px" face="sans-serif" style="italic"  >Valor</font></th>

</tr>
<p align="center">
<?php $cont=0; ?>
@foreach($pro as $pro1)
<?php $cont=$cont+1; ?>
<tr>
<td><font size="13px" face="sans-serif" style="italic"  >@if(strlen($pro1->descripcionproducto)>40) {{strtolower(substr($pro1->descripcionproducto,0,23) )}} {{$pro1->codigobarra1 }}  @else {{strtolower($pro1->descripcionproducto)}} {{$pro1->codigobarra1 }} @endif </font></td>
<td><font size="13px" face="sans-serif" style="italic"  >{{$pro1->stock}}</font></td>
<td><font size="13px" face="sans-serif" style="italic"  >@if($pro1->idtipoproducto==2)
											{{number_format($pro1->preciocompra / $pro1->cantidadempaque *  $pro1->stock)}}
										        @else
                    							
												{{number_format($pro1->stock * $pro1->preciocompra)}}
												
												@endif</font></td>
</tr>
@endforeach
</table></p><br>
===============================
</div>
<div style="width:200px" align="right">
No. productos: <?php echo $cont ?><br>
Costo inventario: {{number_format($sumarray->totalcosto + $sumarray2->totalcosto)}}




</div>

</body>
</html>