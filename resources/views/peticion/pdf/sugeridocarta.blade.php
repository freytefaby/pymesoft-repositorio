

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SUGERIDOS</title>
    <style type="text/css" media="all">



.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 19cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url({{asset('public/images/logo/dimension.png')}});
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 5px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}





</style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{asset('public/images/logo/4_Grayscale_logo_on_transparent_127x74.png')}}" width="80px" height="80px">
      </div>
      <h1>SUGERIDOS DE COMPRAS</h1>
      
      <div id="project">
        <div><span>DROGUERÍA</span> {{$infoempresa->nombrecomercialempresa}}</div>
        <div><span>DIRECCIÓN</span> {{$infoempresa->direccionempresa}}</div>
        <div><span>TELEFONO</span>{{$infoempresa->telefonoempresa}}</div>
        <div><span>NIT</span> {{$infoempresa->nitempresa}}</div>
        <div><span>CIUDAD</span> {{$infoempresa->ciudadempresa}}</div>
        
      </div>
    </header>
   
  <br><br><br><br><br><br>
      <table>
        <thead>
          <tr>
            <th class="service">Producto</th>
            <th class="desc">Laboratorio</th>
            <th>Estock actual</th>
            <th>Minimo</th>
			<th>Sugerido</th>
            <th>Total</th>
           
          </tr>
        </thead>
        <tbody>
        <?php $resultado=0; $cont=0; ?>
@foreach($consulta as $con)
 <?php $resultado=$resultado+$con->costo; $cont=$cont+1; ?>
          <tr>
            <td class="service">{{mb_strtolower($con->descripcionproducto)}}</td>
            <td class="UNIT">{{$con->nombreproveedor}}</td>
			  <td class="unit">{{$con->stock}}</td>
            <td class="unit">{{number_format($con->stockminimo)}}</td>
             <td class="qty">{{number_format($con->cant / $con->ventas)}}</td>
              <td class="total">${{number_format($con->costo)}}</td>
           
          </tr>
          @endforeach
          
          
          <tr>
		   <td></td>
            <td colspan="4">#PRODUCTOS</td>
            <td class="total"><?php echo $cont ?></td>
          </tr>
     
          <tr>
		  <td></td>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">$<?php echo number_format($resultado) ?></td>
          </tr>

        </tbody>
      </table>
      <div id="notices">
        <div>INFO:</div>
        <div class="notice">Sugerido de compras <small>Este tipo de informe se toma en cuenta todos los productos que esten por debajo del minimo requerido y tengan alta rotación en las ventas.</small></div>
      </div>
   
    <footer>
     
Sugerido de compras.
    </footer>
  </body>
</html>