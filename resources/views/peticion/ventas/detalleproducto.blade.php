<table class="table table-bordered  table-condensed">
														<tr>
														
														<th class="hidden-xs hidden-sm"><i class="fa fa-barcode" aria-hidden="true"></i> Codigo</th>
														<th><i class="fa fa-product-hunt" aria-hidden="true"></i> Producto</th>
														<th class="hidden-xs hidden-sm"><i class="fa fa-heartbeat" aria-hidden="true"></i> Laboratorio</th>
														<th class="hidden-xs hidden-sm"><i class="fa fa-cart-plus" aria-hidden="true"></i> Cantidad</th>
														<th class="hidden-xs hidden-sm"><i class="fa fa-money" aria-hidden="true"></i> Precio</th>
														<th class="hidden-xs hidden-sm"><i class="fa fa-money" aria-hidden="true"></i> Subtotal</th>
														<th class="hidden-xs hidden-sm"><i class="fa fa-trash" aria-hidden="true"></i> Quitar</th>
														</tr>
														
														@foreach($detalleventa as $pro )
														
														<tr>
														
														<td class="hidden-xs hidden-sm">{{$pro->codigobarra1}}  <input type="hidden" id="codigo" value="{{$pro->codigobarra1}}"></td>
														<td>{{$pro->descripcionproducto}}</td>
														<td class="hidden-xs hidden-sm">{{$pro->nombreproveedor}}</td>
														<td class="hidden-xs hidden-sm">{{$pro->cantidad}}</td>
														<td class="hidden-xs hidden-sm">{{number_format($pro->valor)}}</td>
														<td class="hidden-xs hidden-sm">{{number_format($pro->subtotal)}}</td>
														<td class="hidden-xs hidden-sm"><button class="btn btn-xs btn-danger" title="Eliminar" value="{{$pro->iddetalleventa}}" onclick="eliminar(this)" >
																<i class="fa fa-trash" aria-hidden="true"></i> Quitar
															</button></td>
														</tr>
														<tr bgcolor="#0A122A"  class="hidden-md hidden-lg"><td> <font color="white"> Cantidad: {{$pro->cantidad}} <br> Precio {{number_format($pro->valor)}} </font></td> </tr>
														<tr  class="hidden-md hidden-lg"><td> <button class="btn btn-xs btn-danger" title="Eliminar" value="{{$pro->iddetalleventa}}" onclick="eliminar(this)" >
																<i class="fa fa-trash" aria-hidden="true"></i> Quitar
															</button></td></tr>
														@endforeach
														<tfoot>
												
														
														<tr>
														<td>Item: {{$sumarray->detalle}} </td>
														<td class="hidden-xs hidden-sm"></td>
														<td class="hidden-xs hidden-sm"></td>
														<td class="hidden-xs hidden-sm">T: {{$sumarray->cant}}</td>
														<td class="hidden-xs hidden-sm">T: {{number_format($sumarray->val)}}</td>
														<td class="hidden-xs hidden-sm">T: {{number_format($sumarray->sub)}}</td>
														<td class="hidden-xs hidden-sm"></td>
														</tr>
														
														</tfoot>
														
														</table>
														
														
		<script>
		function eliminar (btn){
			var token=$("#token").val();
			var codigo=$("#codigo").val();
			route="delete/"+btn.value+"";
			$.ajax({
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'POST',
				datatype:'json',
				success:function(data)
				{
				 alert("Producto eliminado correctamente");
					  $("#detalle").load("{{URL('peticion/detalleproductos')}}");
					  $("#detalleventa").load("{{URL('peticion/ventajax')}}");
					  $("#resultado").load("ajaxproductos/"+codigo);
					  $("#buscar").focus();
				
				},
				error:function(msj)
				{
					alert("RESPUESTA NO PUDO SER RECIBIDA, INTENTALO MAS TARDE");
				}
				
				
				
			});
			
			
		}
		
		
		</script>