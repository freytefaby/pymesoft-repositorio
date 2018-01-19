@if(count($articulos)==0)
	<div class="alert-warning"><h3>Producto no encontrado, <a href="{{URL('peticion/productosurl/'.$id)}}">[Crear producto]</a><h3></div>
@else
	
	<br><br>
	<div class="responsive">
<table class="table table-bordered">
														<tr bgcolor="#0A122A" >
														<th class="hidden-xs hidden-sm"  ><font color="white">Codigo</font></th>
														<th class="hidden-xs hidden-sm" ><font color="white">Desc</font></th>
														<th class="hidden-xs hidden-sm"><font color="white">Stock</font></th>
														<th class="hidden-xs hidden-sm"> <font color="white">p.publico(S/I)</font></th>	
														<th class="hidden-xs hidden-sm"><font color="white">Iva</font></th>
														<th class="hidden-xs hidden-sm"><font color="white">Cantidad</font></th>
														<th class="hidden-xs hidden-sm"><font color="white">Unidad</font></th>
														<th  class="hidden-xs hidden-sm"><font color="white">Agregar</font></th>
														</tr>
														
														
@foreach ($articulos as $art)

<div class="hidden-md hidden-lg">{{$art->descripcionproducto}}</div>
														<tr>
														<td class="hidden-xs hidden-sm">
														{{$art->codigobarra1}}
														</td>
														<td class="hidden-xs hidden-sm">
														
														{{strtolower($art->descripcionproducto)}}
														<input type="hidden" id="producto"  value="{{$art->descripcionproducto}}">
														</td>
														<td class="hidden-xs hidden-sm">
														{{$art->stock}}
														</td>
														<td class="hidden-xs hidden-sm">
														<input type="hidden" name="preciosugerido" id="preciosugerido" value="{{$art->preciosugerido}}">
														{{number_format($art->preciosugerido)}}
														</td>
														<td  class="hidden-xs hidden-sm">
														<input type="hidden" name="iva" id="iva" value="{{$art->valoriva}}">
														<input type="hidden" name="comision"  id="comision" value="{{$art->comision}}">
														<input type="hidden" name="codigo_barra" id="codigo_barra" value="{{$art->codigobarra1}}">
														{{$art->valoriva}}%
														</td>
														<td class="hidden-xs hidden-sm" >
			                                       @if($art->idtipoproducto==1)
													   <input disabled type="text" name="cant"  style="width:60px;" >
												      @else
														<input type="number" name="cant" id="cant"  style="width:60px;" >
													  @endif
														</td>
														<td class="hidden-xs hidden-sm" >
														<input type="number" name="und" id="und"  style="width:60px;" >
														</td>
														<td  class="hidden-xs hidden-sm">
														
															<a href="javascript:void(0)" class="btn btn-xs btn-info" title="Agregar" id="agregar">
															<i class="ace-icon fa fa-check bigger-110"></i> Agregar
															</a>
														</td>
														<input type="hidden" name="idproducto" id="idproducto" value="{{$art->idproducto}}">
														
														<input type="hidden" name="tipoproducto" id="tipoproducto" value="{{$art->idtipoproducto}}">
														<input type="hidden" name="cantidadempaque" id="cantidadempaque" value="{{$art->cantidadempaque}}">
														<input type="hidden" name="validarcantidad" id="validarcantidad">
														<input type="hidden" name="utilidad" id="utilidad" value="{{$art->preciocompra}}">
														<input type="hidden" name="stock" id="stock" value="{{$art->stock}}">
														<input type="hidden" name="idventa" id="idventa" value="{{$ultimaventa->idventa}}">
														</tr>
														
														<tr class="hidden-md hidden-lg" bgcolor="#0A122A" ><td style="width:60px;"><font color="white">Cantidad</font></td><td style="width:60px;"><font color="white">Unidad</font></td></tr>
														<tr>
														<td class="hidden-md hidden-lg">
														@if($art->idtipoproducto==1)
													   <input disabled type="text" name="cant"  style="width:60px;" >
												      @else
														<input type="number" name="cant2" id="cant2"  style="width:60px;" >
													  @endif
														</td>
														<td class="hidden-md hidden-lg">
														<input type="number" name="und2" id="und2"  style="width:60px;" >
														</td></tr>
															<tr>
															<td class="hidden-md hidden-lg">
															<a href="javascript:void(0)" class="btn btn-xs btn-info" title="Agregar" id="agregar2">
															<i class="ace-icon fa fa-check bigger-110"></i> Agregar
															</a>
															</td>
															<td class="hidden-md hidden-lg">Disponible: {{$art->stock}}</td>
															</tr>
														
														
														@endforeach
														
													</table>
													
													
													</div>
													
													
@endif


<script>
	
		$("#agregar").click(function(){
			$("#agregar").hide();
			var stock=$("#stock").val();
			var utilidad=$("#utilidad").val();
			var validarcantidad=$("#validarcantidad").val();
			var cantidadempaque=$("#cantidadempaque").val();
			var tipoproducto=$("#tipoproducto").val();
			var idproducto=$("#idproducto").val();
			var und=$("#und").val();
			var cant=$("#cant").val();
			var codigo_barra=$("#codigo_barra").val();
			var comision=$("#comision").val();
			var iva=$("#iva").val();
			var preciosugerido=$("#preciosugerido").val();
			var producto=$("#producto").val();
			var token=$("#token").val();
			var route="detalle_venta";
			var idventa=$("#idventa").val();
			var dataString="stock="+stock+"utilidad="+utilidad+"validarcantidad="+validarcantidad+"cantidadempaque="+cantidadempaque;
			$.ajax({
				
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'post',
				datatype:'json',
				data:{stock:stock, utilidad:utilidad, validarcantidad:validarcantidad, cantidadempaque:cantidadempaque, tipoproducto:tipoproducto, idproducto:idproducto, und:und, cant:cant, codigo_barra:codigo_barra, comision:comision, iva:iva, preciosugerido:preciosugerido, idventa:idventa},
				success:function(data)
				{
					if(data.mensaje=="3")
					{
						
				$("#msj-success").fadeIn();
				$("#msj-success").delay(1000).hide(600);
				//setTimeout("location.href='{{url('peticion/ventas/create')}}'",3000);
				   $("#detalle").load("{{URL('peticion/detalleproductos')}}");
				   $("#detalleventa").load("{{URL('peticion/ventajax')}}");
				   $("#resultado").load("ajaxproductos/"+codigo_barra);
				   $("#buscar").focus();
				   
					}
					else{
				$("#agregar").show();
			    $("#msj-error").fadeIn();
				$("#msj-error").delay(1000).hide(600);
				$("#mensaje").html(data.mensaje);
				}
				
				console.log(data.mensaje);
				
				},
				error:function(msj)
				{
					alert("RESPUESTA NO PUDO SER RECIBIDA, INTENTALO MAS TARDE");
				}
				
				
				
			});
			
			
		});   
		
		
		
		////////////////////////////////////
		
		
		$("#agregar2").click(function(){
			$("#agregar").hide();
			var stock=$("#stock").val();
			var utilidad=$("#utilidad").val();
			var validarcantidad=$("#validarcantidad").val();
			var cantidadempaque=$("#cantidadempaque").val();
			var tipoproducto=$("#tipoproducto").val();
			var idproducto=$("#idproducto").val();
			var und=$("#und2").val();
			var cant=$("#cant2").val();
			var codigo_barra=$("#codigo_barra").val();
			var comision=$("#comision").val();
			var iva=$("#iva").val();
			var preciosugerido=$("#preciosugerido").val();
			var producto=$("#producto").val();
			var token=$("#token").val();
			var route="detalle_venta";
			var idventa=$("#idventa").val();
			var dataString="stock="+stock+"utilidad="+utilidad+"validarcantidad="+validarcantidad+"cantidadempaque="+cantidadempaque;
			$.ajax({
				
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'post',
				datatype:'json',
				data:{stock:stock, utilidad:utilidad, validarcantidad:validarcantidad, cantidadempaque:cantidadempaque, tipoproducto:tipoproducto, idproducto:idproducto, und:und, cant:cant, codigo_barra:codigo_barra, comision:comision, iva:iva, preciosugerido:preciosugerido, idventa:idventa},
				success:function(data)
				{
					if(data.mensaje=="3")
					{
						
				$("#msj-success").fadeIn();
				$("#msj-success").delay(1000).hide(600);
				//setTimeout("location.href='{{url('peticion/ventas/create')}}'",3000);
				   $("#detalle").load("{{URL('peticion/detalleproductos')}}");
				   $("#detalleventa").load("{{URL('peticion/ventajax')}}");
				   $("#resultado").load("ajaxproductos/"+codigo_barra);
				   $("#buscar").focus();
				   
					}
					else{
				$("#agregar").show();
			    $("#msj-error").fadeIn();
				$("#msj-error").delay(1000).hide(600);
				$("#mensaje").html(data.mensaje);
				}
				
				console.log(data.mensaje);
				
				},
				error:function(msj)
				{
					alert("RESPUESTA NO PUDO SER RECIBIDA, INTENTALO MAS TARDE");
				}
				
				
				
			});
			
			
		});   
		
		</script>
		