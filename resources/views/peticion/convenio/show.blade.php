@extends('layouts.template')

@section('content')

<div class="main-content">
				<div class="main-content-inner">
					

					<div class="page-content">
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->

						<div class="page-header">
							<h1>
								Convenios
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
								Crud mantenimiento Convenios a cliente.
								</small>
							</h1>
							
						</div><!-- /.page-header -->
                           
								 @if(Session::has('mensaje'))
                                           <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{Session::get('mensaje')}}.
            </div>
                                     @endif
									 @if(Session::has('mensaje1'))
                                           <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
            </i> {{Session::get('mensaje1')}}.
            </div>
                                     @endif
						<div class="row">
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
							
							
									
									
							
									
										
									
									<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
                                    
									<tr>
									<th>Nombre cliente</th>
									<th>Valor de convenio</th>
								    <th>Facturas</th>
									
									
									
									</tr>
									
									</thead>
									
                                    <tbody>
								
									<?php $cont=0; $sumcon=0; $cupo=0;?>
									@foreach($consulta as $con)
									<?php $cont=$cont+1; $sumcon=$sumcon+$con->valorconvenio;?>
									
									<tr>
									<td>{{$con->nombrecliente}}</td>
                                    <td>{{number_format($con->valorconvenio)}}</td>
                                    <td>{{$con->facturascadena}}</td>
									
									
									</tr>
									@endforeach
								
									
								
                                    </tbody>
									<tfoot>
									<tr>
									<th>{{$cont}}</th>
									<th>{{number_format($sumcon)}}</th>
									<th></th>
									<th></th>
									</tr>	
									</tfoot>
									</table>
													  
									
							
								
										
							
								

								<div class="hr hr-18 dotted hr-double"></div>
								<div class="col-xs-12 col-md-4">
                            <div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>

											<p>
												<strong>
													<i class="ace-icon fa fa-check"></i>
												Finalizar Convenio o pago de abono
												</strong>
												<br>
                                               
                                                Valor Convenio: {{number_format($convenio->valorconvenio)}}<br>
												Abonos del cliente: {{count($abonos)}}<br>
                                                Cupo maximo para convenio: {{number_format($convenio->valor_maximo)}}<br>
                                                Fecha Limite de pago: <?php $a=fecha_credito($convenio->fechaconvenio,$convenio->dias_cupo); echo fecha($a)?><br>
                                                Fecha Creacion Convenio: {{fecha($convenio->fechaconvenio)}}<br>
                                                Dias para credito: {{$convenio->dias_cupo}}
											</p>

											
										</div>
                                       
                            
                            
                            
                            </div>
								

							
							
							<div class="col-md-8">
							
							<H1>Plan pagos de abonos de clientes</h1>
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
									<tr>
									<th>#</th>
									<th>Fecha de abono</th>
									<th>Valor de abono</th>
								   
									
									
									</tr>
									
									</thead>
									<?php $cont2=0; $sumcon2=0;?>
                                    <tbody>
									@foreach($abonos as $det)
									<?php $cont2=$cont2+1; $sumcon2=$sumcon2 + $det->valorabono; ?>
									
									
									<tr>
									<td><?php echo $cont2 ?></td>
									<td>{{fecha($det->fecha_abono)}}</td>
									<td>{{number_format($det->valorabono)}}</td>
									
									
									
									</tr>
									
								
									
									@endforeach
                                    </tbody>
									<tfoot>
									<tr>
									<th></th>
									<th></th>
									<th>{{number_format($sumcon2)}}</th>
									
									
									</tr>	
									</tfoot>
									</table>
							</div>

							
						

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
                            
                            
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->


@endsection

@section('scripts')

	

	<script src="{{asset('public/js/jquery-2.1.4.min.js')}}"></script>

	<script>
	
	function checkSubmit() {
		document.getElementById("agregar").value = "Enviando...";
		document.getElementById("agregar").disabled = true;
		return true;
	}
	
	
	</script>
		
			<!--<script>
		$("#buscar").keypress(function(e){
			
			if(e.which == 13){
				$("#loader").css("display","block");
				var busqueda = $("#buscar").val();
				$.get("convenio/busqueda_cliente_convenio/"+busqueda,function(datos){
					
					$("#resultado").html(datos);
					 
					$("#loader").css("display","none");
					
				});
				
				 $("#buscar").val('');
				 $("#und").focus();
			}
			
		
         
			
		});
		
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{asset('public/js/jquery.mobile.custom.min.js')}}'>"+"<"+"/script>");
		</script>
		<script src="{{asset('public/js/bootstrap.min.js')}}"></script>

		<!-- page specific plugin scripts -->
		<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.dataTables.bootstrap.min.js')}}"></script>
		<script src="{{asset('public/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('public/js/buttons.flash.min.js')}}"></script>
		<script src="{{asset('public/js/buttons.html5.min.js')}}"></script>
		<script src="{{asset('public/js/buttons.print.min.js')}}"></script>
		<script src="{{asset('public/js/buttons.colVis.min.js')}}"></script>
		<script src="{{asset('public/js/dataTables.select.min.js')}}"></script>

		<!-- ace scripts -->
		<script src="{{asset('public/js/ace-elements.min.js')}}"></script>
		<script src="{{asset('public/js/ace.min.js')}}"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, 
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'Producido por PYMESOFT.LTE'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>
@endsection
