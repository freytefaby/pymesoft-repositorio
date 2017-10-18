<div>
															<label for="form-field-select-3">Cliente:</label>

															<br />
															<input type="number" id="cliente" class="form-control"> <div id="cedulacliente"  style="display:none;"><strong id="nombrecliente"></strong></div>
														</div>

														<hr />
														<div>
															<label for="form-field-select-3">Tipo venta:</label>

															<br />
															<select class="chosen-select form-control" name="tipoventa" id="tipoventa" data-placeholder="Seleccione">
																<option value=""> Seleccione</option>
																
																@foreach($tipoventa as $tv)
																@if(Session::get('tipoventa')==$tv->idtipoventa)
															    <option value="{{$tv->idtipoventa}}" selected>{{$tv->desctipoventa}}</option>
															    @else
																@if(old('tipoventa')==$tv->idtipoventa)
																<option value="{{$tv->idtipoventa}}" selected>{{$tv->desctipoventa}}</option>
															    @else
																<option value="{{$tv->idtipoventa}}">{{$tv->desctipoventa}}</option>
															    @endif
																@endif
																@endforeach
																
															</select>
														</div>
														<hr/>
														<div>
														<div class="infobox infobox-green">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-money"></i>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">{{number_format($sumarray->val)}}</span>
												<div class="infobox-content">Total a pagar</div>
											</div>

											
										</div>
														
														</div>
														<hr/>
														<div>
															<label for="form-field-mask-2">
																Descuento
															</label>

															<div class="input-group">
																<span class="input-group-addon">
																		<i class="ace-icon fa fa-money"></i>
																</span>
																
																<input class="form-control" type="number" id="descuento"   name="descuento" />
														
															
															</div>
														</div>
														<hr/>
														<div>
															<label for="form-field-mask-2">
																Valor
															</label>

															<div class="input-group">
																<span class="input-group-addon">
																		<i class="ace-icon fa fa-money"></i>
																</span>
																
                                                    
															 
																<input class="form-control" type="number"  min="1" required name="valor" id="valor" />
														
															
															</div>
														</div><br>
           
														<hr />
														
                                            <button class="btn btn-xs btn-success" title="Facturar" id="venta">
																<i class="ace-icon fa fa-check bigger-110"></i> Facturar
															</button>
															
															 <div class="alert alert-warning" id="msj-cliente" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong id="errorcliente" ></strong>
            </div>
			 <div class="alert alert-warning" id="msj-tipoventa" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong id="errortipoventa" ></strong>
            </div>
			 <div class="alert alert-warning" id="msj-valor" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong id="errorvalor" ></strong>
            </div>
			<div class="alert alert-warning" id="msj-producto" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong id="erroproducto" ></strong>
            </div>
			<div class="alert alert-success" id="msj-success2" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-check bigger-110" aria-hidden="true"></i> <strong>Registrando la venta  <i class="ace-icon fa fa-spinner fa-spin green bigger-125"></i></strong>
            </div>
															<!--IMPUTS-->
															<input type="hidden" name="valorventa" id="valorventa" value="{{$sumarray->val}}">
															<input type="hidden" name="subtotal" id="subtotal" value="{{$sumarray->sub}}">
															<input type="hidden" name="utilidad2" id="utilidad2" value="{{$sumarray->utilidad}}">
															<input type="hidden" name="comis" id="comis" value="{{$sumarray->comi}}">
															 <input type="hidden" name="_token" value="{{csrf_token()}}" id="token2">
															 <input type="hidden" id="idcliente" >
															 <input type="hidden" id="ultimaventa" value="{{$ultimaventa->idventa}}">
															
								<script>
	$(document).ready(function(){
		var tipoventa=$("#tipoventa").val();
		
		
	$("select[name=tipoventa]").change(function(){
		 if($('select[name=tipoventa]').val()==5)
		 {
            alert('Se ha activado nuevo convenio');
            $('input[name=valor]').val({{$sumarray->val}});
			$('input[name=valor]').val({{$sumarray->val}});
			$('input[name=descuento]').prop('disabled',true);
				}
				else
				{
					$('input[name=valor]').val("");
					$('input[name=descuento]').prop('disabled',false);
					
				}
		});
	
});
								
								
								</script>							
							<script>
							$("#cliente").blur(function(e){
			
		
			var busqueda = $("#cliente").val();
		    var token=$("#token2").val();
			if(busqueda.lenght <= 0 )
			{
				alert("Es necesario digitar un numero de cedula o identifiación para arrojar datos");
				
			};
			var route="clientes/"+busqueda+"";
			$.ajax({
				
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'GET',
				datatype:'json',
				data:{busqueda:busqueda},
				success:function(data)
				{
					if(data.mensaje=="desconocido")
					{    
			            $("#cedulacliente").fadeIn();
						$("#nombrecliente").html("Cliente no existe");
						$("#idcliente").val("");
					}
					else{
						
						$("#cedulacliente").fadeIn();
					$("#nombrecliente").html(data.nombre);
					$("#idcliente").val(data.mensaje);
					}
					
					console.log(data.mensaje)
					
								
				}
				,
				
				
				
				
			});
				
				
				
				
				//////////////////////////////////////////////////////////////// PETICION TIPO GET /////////////////////////////////////////
				//$("#cargacliente").css("display","block");
				//var busqueda = $("#cliente").val();
				//$.get("clientes/"+busqueda,function(datos){
					//var nombre=datos;
					//alert("tu nombre es"+datos)
					//$("#cliente").html(datos);
					 
					//$("#cargacliente").css("display","none");
					
					
				//});
				
				 
				
			
			
		
         
			
		});
							
							
							
							
							
							</script>		
<script>
								$("#prueba").click(function(){
									var cliente=$("#idcliente").val();
									console.log(cliente);
									alert("mi id es"+" "+cliente );
									
								})
								</script>							
	<script>
	
	$("#venta").click(function(){
			
			var cliente=$("#idcliente").val();
			var tipoventa=$("#tipoventa").val();
			var descuento=$("#descuento").val();
			var valor=$("#valor").val();
			var valorventa=$("#valorventa").val();
			var subtotal=$("#subtotal").val();
			var utilidad2=$("#utilidad2").val();
			var comis=$("#comis").val();
			var idcliente=$("#idcliente").val();
			var ultimaventa=$("#ultimaventa").val();
			var token=$("#token2").val();
			var route="update/"+ultimaventa+"";
			$.ajax({
				
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				type:'PUT',
				datatype:'json',
				data:{cliente:cliente, tipoventa:tipoventa, descuento:descuento, valor:valor, valorventa:valorventa, subtotal:subtotal, utilidad2:utilidad2, comis:comis, idcliente:idcliente, ultimaventa:ultimaventa},
				
				success:function(data)
				{
                            if(data.mensaje == "success")
						 {
							  $("#msj-success2").fadeIn();
							$("#venta").hide();
							 setTimeout("location.href='{{url('peticion/ventas')}}'",3000);
						 }
						 else{
							 
					$("#msj-producto").fadeIn();
					$("#erroproducto").html(data.mensaje);
						 
					 }
					  $("#msj-success2").delay(2000).hide(600);
					  
					 
					
					 
				$("#msj-producto").delay(3000).hide(600);
				console.log(data.mensaje);
					
				   
			
				
				},
				error:function(data)
				{
					 if(data.responseJSON.cliente !== undefined)
					 {
						 $("#msj-cliente").fadeIn();
					$("#errorcliente").html(data.responseJSON.cliente);
						 
					 }
					 else{
						 
						  $("#msj-cliente").hide();
					 }
					 
					 
					 if(data.responseJSON.tipoventa !== undefined)
					 {
						 $("#msj-tipoventa").fadeIn();
					$("#errortipoventa").html(data.responseJSON.tipoventa);
						 
					 }
					 else{
						 
						  $("#msj-tipoventa").hide();
					 }
					  if(data.responseJSON.valor !== undefined)
					 {
						 $("#msj-valor").fadeIn();
					$("#errorvalor").html(data.responseJSON.valor);
						 
					 }
					 else{
						 
						  $("#msj-valor").hide();
					 }
					 
					
					$("#msj-cliente").delay(3000).hide(600);
					$("#msj-tipoventa").delay(3000).hide(600);
					$("#msj-valor").delay(3000).hide(600);
						
                          console.log(data.responseJSON);
                               
				}
				
				
				
			});
			
			
		});   
	
	
	
	
	
	
	
	
	
	
	
	
	
	</script>