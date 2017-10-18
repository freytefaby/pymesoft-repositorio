
<div style="overflow:scroll; height:430px;">
<table id="dynamic-table" class="table table-striped table-bordered table-hover table-condensed">
												<thead>
													<tr>
														<th>Producto</th>
														<th class="hidden-xs hidden-sm">Laboratorio</th>
														<th class="hidden-xs hidden-sm">Codigo</th>
														<th class="hidden-xs hidden-sm">Stock</th>
														

														
													</tr>
												</thead>
                                          <tbody>
														
											@foreach($medicamento as $med)
											
												<tr>
													<TD class="hidden-xs hidden-sm"><a href="{{URL('peticion/ventas/create?p='.$med->codigobarra1)}}">{{$med->descripcionproducto}} </a> </TD>
													<TD class="hidden-xs hidden-sm">{{$med->nombreproveedor}}</TD>
													<td class="hidden-xs hidden-sm">{{$med->codigobarra1}}</td>
													<td class="hidden-xs hidden-sm">{{$med->stock}}</td>
												  
												</tr>
                                        <tr c><td class="hidden-md hidden-lg" ><a href="{{URL('peticion/ventas/create?p='.$med->codigobarra1)}}">{{$med->descripcionproducto}} </a> <br> {{$med->nombreproveedor}} <br>  {{$med->codigobarra1}} <br> Stock {{$med->stock}} </td></tr>
												@endforeach
												
												

								     
												</tbody>
											</table>
											
</div>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		
		