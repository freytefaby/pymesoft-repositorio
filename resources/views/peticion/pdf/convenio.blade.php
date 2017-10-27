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
 font-family: "dejavu sans";
 font-size:12px;
 margin: 0mm 0mm 0mm 8mm;
}
</style>

<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>

<body>


<div style="width:240px" align="center">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
  {{$infoempresa->nombrecomercialempresa}}<br>
   Dir: {{$infoempresa->direccionempresa}}<BR>
   Tel: {{$infoempresa->telefonoempresa}}<br>
   Nit: {{$infoempresa->nitempresa}}<br>
   Ciudad: {{$infoempresa->ciudadempresa}}<br>
	  Factura simplificada<br>
	  {{fecha($convenio->fechaconvenio)}}



	
	  <p style="margin: 0; padding: 0;">============================================
	Convenio: HHFCO-00{{$convenio->idconvenio}}
	  ============================================</p>
	  </font>
	
	  </div>
<div  style="width:240px; margin: 0mm 0mm 0mm 0mm;" align="left" >
	  <P ALIGN="center" style="margin: 0; padding: 0;" ><i>FACTURAS DE CONVENIOS</i></p>
<p style="margin: 0; padding: 0;">
<?php $cont=0; ?>
@foreach($consulta as $conv)
<?php $cont=$conv->valorconvenio + $cont; ?>
({{$conv->facturascadena}}) {{number_format($conv->valorconvenio)}}<br>
  
@endforeach
<b>Total: <?php echo number_format($cont); ?> </b>
</p>
</div>
<div style="width:240px; margin-bottom: 0; padding: 0;" align="center" >
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
 
	  <p style="margin: 0; padding: 0;">============================================</p>
	  
	  </div>

<div style="width:240px;" align="left">
<P style="margin: 0; padding: 0;" ALIGN="center" ><i>ABONOS</i></p>
<?php $cont1=0; $abono=0; ?>
@foreach($abonos as $ab)
<?php $cont=$conv->valorconvenio + $cont; $abono=$abono+$ab->valorabono; ?>
({{fecha($ab->fecha_abono)}}) {{number_format($ab->valorabono)}}<br>
  
@endforeach
<b>total: <?php echo number_format($abono) ?></b>
</div>

<div style="width:240px " align="left">
<!--<h3><img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="100px"></h3>-->
  
	  <p align="center" style="margin: 0; padding: 0;">============================================ <br>
	  <i>CLIENTE</i></p>
	  Nombre: {{$convenio->nombrecliente}}<br>
	  Apellido:
	   @if($convenio->apellidocliente=="")
	  NULL
	  @else
	  {{$convenio->apellidocliente}}
	  @endif <BR>
	  Cedula: {{$convenio->cedulacliente}} <br>
	  Direccion: {{$convenio->direccioncliente}} <br>
	  Telelfono: {{$convenio->telefonocliente}}

	  <p align="center" style="margin: 0; padding: 0;">============================================
	  <i>DETALLES DEL CONVENIO</i></p>
     Valor convenio: <b>{{number_format($convenio->valorconvenio)}}</b><br>
     Valor abonado: <b>{{number_format($abono)}}</b><br>
	 Credito a: <b>{{$convenio->dias_cupo}} Dias</b><br>
	 Valor de cupo: <b>{{number_format($convenio->valor_maximo)}}</b>
	  </div>

	  


</body>
</html>