<!DOCTYPE html>

<html lang="es">

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Convenio HHCO-00{{$id}}</title>


<link rel="shortcut icon" href="/favicon.ico" />
<style>
   <?php include(public_path().'/css/bootstrap.min.css');?>
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


<div style="width:200px" align="center">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
  {{$infoempresa->nombrecomercialempresa}}<br>
   Dir: {{$infoempresa->direccionempresa}}<BR>
   Tel: {{$infoempresa->telefonoempresa}}<br>
   Nit: {{$infoempresa->nitempresa}}<br>
   Ciudad: {{$infoempresa->ciudadempresa}}<br>
	  Factura simplificada<br>
	  {{fecha($convenio->fechaconvenio)}}



	
	  <p>============================================
	Convenio: HHFCO-00{{$convenio->idconvenio}}
	  ============================================</p>
	  </font>
	
	  </div>
<div  style="width:240px; margin: 0mm 0mm 0mm 0mm;" align="left" >
	  <P ALIGN="center">Facturas que se genero convenios</p>
<p>
<?php $cont=0; ?>
@foreach($consulta as $conv)
<?php $cont=$conv->valorconvenio + $cont; ?>
({{$conv->facturascadena}}) {{number_format($conv->valorconvenio)}}<br>
  
@endforeach
<b>Total: <?php echo number_format($cont); ?> </b>
</p>
</div>
<div style="width:200px" align="center">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
 
	  <p>============================================</p>
	  
	  </div>

<div style="width:200px" align="left">
<P ALIGN="center">Abonos</p>
<?php $cont1=0; ?>
@foreach($abonos as $ab)
<?php $cont=$conv->valorconvenio + $cont; ?>
({{fecha($ab->fecha_abono)}}) {{number_format($ab->valorabono)}}<br>
  
@endforeach

</div>

<div style="width:200px " align="center">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
  
	  <p>============================================</p>
	  
	  </div>

	  <div style="width:200px" align="center">

============================================<br>
MUCHAS GRACIAS POR TU COMPRA, TE ESPERAMOS NUEVAMENTE!!
<br>
============================================
</font>
</div>


</body>
</html>