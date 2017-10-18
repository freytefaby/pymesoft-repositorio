<div class="row">
									<div class="col-xs-12">
										

										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										
										<div class="table-header">
											Registros disponibles
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>Fecha</th>
														<th>Cliente</th>
														<th>Usuario</th>
														<th>No factura</th>
														<th>Valor</th>
														<th>Validar</th>
														


														
													</tr>
												</thead>
                                          <tbody>
										       <?php $a=0; ?>
												@foreach($cliente as $client)	
                                               <?php $a=$a+1; ?>												
											<tr>
											<td>{{fecha($client->fecha)}}</td>
											<td>{{$client->nombrecliente}}</td>
											<td>{{$client->user}}</td>
											<td>HHF-00{{$client->idtipoventa}}{{$client->idventa}}</td>
											<td>${{number_format($client->valorventa)}}</td>
											<td><input type="checkbox" name="convenio[]"  value="{{$client->idventa}}"></td>
											
											</tr>

								                @endforeach
												</tbody>
											</table>
											
											<button class="btn btn-primary" type="button" id="con">
												<i class="ace-icon glyphicon glyphicon-plus"></i>
												Validar convenios
											</button>
										</div>
									</div>
								</div>
		<script src="{{asset('public/js/jquery-2.1.4.min.js')}}"></script>						
	<!--<script>
	
	$(function() {
    $('#con').click(function() {
        var categorias = new Array();
		
 
        $("input[name='convenio[]']:checked").each(function() {
            categorias.push($(this).val());
			
        });
       
	   var route="datos";
			$.ajax({
				
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'get',
				datatype:'json',
				data:{convenio:  categorias},
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
				
        console.log( JSON.stringify($('[name="convenio[]"]').serializeArray()));
		
		
		
    });
});
	
	</script> -->
	