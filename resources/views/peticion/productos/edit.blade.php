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
								Formulario Productos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Editar producto {{$productos->descripcionproducto}}
								</small>
							</h1>
						</div><!-- /.page-header -->
					
					<div class="row">
							<div class="col-xs-12">
							@if(Session::has('mensaje'))
                                           <div class="alert alert-warning">
                               <button type="button" class="close" data-dismiss="alert">x</button>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{Session::get('mensaje')}}
                                             </div>
                                     @endif
								<!-- PAGE CONTENT BEGINS -->
								@if (count($errors)>0)
								<div class="row">
								<div class="col-md-12" >
								<div class="alert alert-danger">
								<ul>
								@foreach ($errors->all() as $error)
								<li >{{$error}}</li>
								@endforeach
								</ul>
								</div>
								</div>
								</div>
								@endif
				
				{!!Form::model($productos,['method'=>'PATCH','route'=>['peticion.productos.update',$productos->idproducto]])!!}
					{{Form::token()}}
				                    <div class="row">
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">producto:</label>
    @if(Session::get('producto')=="")
      <input type="text" name="producto" class="form-control" id="inputPassword3" placeholder="Producto" value="{{$productos->descripcionproducto}}">
    @else
		<input type="text" name="producto" class="form-control" id="inputPassword3" placeholder="Producto" value="{{session::get('producto')}}">
	 @endif
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Codigo de barras 1</label>
     @if(Session::get('codigobarra1')=="")
      <input type="text" name="codigobarra1" class="form-control" id="inputPassword3" placeholder="Codigo de barras 1" value="{{$productos->codigobarra1}}">
   @else
	   <input type="text" name="codigobarra1" class="form-control" id="inputPassword3" placeholder="Codigo de barras 1" value="{{session::get('codigobarra1')}}">
   @endif
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Codigo de barras 2</label>
     @if(Session::get('codigobarra2')=="")
      <input type="text" name="codigobarra2" class="form-control" id="inputPassword3" placeholder="Codigo de barras 2" value="{{$productos->codigobarra2}}">
     @else
	  <input type="text" name="codigobarra2" class="form-control" id="inputPassword3" placeholder="Codigo de barras 2" value="{{session::get('codigobarra2')}}">
   @endif
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Codigo de barras 3</label>
    @if(Session::get('codigobarra3')=="")
      <input type="text" name="codigobarra3" class="form-control" id="inputPassword3" placeholder="Codigo de barras 3"  value="{{$productos->codigobarra3}}">
   @else
	    <input type="text" name="codigobarra3" class="form-control" id="inputPassword3" placeholder="Codigo de barras 3"  value="{{session::get('codigobarra3')}}">
   @endif
  </div>
  
  </div>
  
  </div>
   <div class="row">
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Codigo de barras 4:</label>
    @if(Session::get('codigobarra4')=="")
      <input type="text" name="codigobarra4" class="form-control" id="inputPassword3" placeholder="Codigo de barras 4"  value="{{$productos->codigobarra4}}">
    @else
		
      <input type="text" name="codigobarra4" class="form-control" id="inputPassword3" placeholder="Codigo de barras 4"  value="{{session::get('codigobarra4')}}">
	  @endif
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Tipo producto</label>
    
      <select class="chosen-select form-control" name="tipoproducto" id="form-field-select-3" data-placeholder="Seleccione">
																<option value=""> </option>
																
																@foreach($tipo as $tp)
																@if(Session::get('tipoproducto')==$tp->idtipoproducto)
															    <option value="{{$tp->idtipoproducto}}" selected>{{$tp->descripciontipoproducto}}</option>
															    @else
																@if($productos->idtipoproducto==$tp->idtipoproducto)
																<option value="{{$tp->idtipoproducto}}" selected>{{$tp->descripciontipoproducto}}</option>
															    @else
																<option value="{{$tp->idtipoproducto}}">{{$tp->descripciontipoproducto}}</option>
															    @endif
																@endif
																@endforeach
																
															</select>
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
   <label for="inputPassword3">Cantidad de caja</label>
   @if(Session::get('cantidadempaque')=="")
    <input type="number" name="cantidadempaque" class="form-control" id="inputPassword3" placeholder="Cantidad por caja" value="{{$productos->cantidadempaque}}">
   @else
	<input type="number" name="cantidadempaque" class="form-control" id="inputPassword3" placeholder="Cantidad por caja" value="{{session::get('cantidadempaque')}}">
  @endif
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Minimo stock</label>
    @if(Session::get('stockminimo')=="")
      <input type="number" name="stockminimo" class="form-control" id="inputPassword3" placeholder="Minimo stock" value="{{$productos->stockminimo}}">
    @else
		<input type="number" name="stockminimo" class="form-control" id="inputPassword3" placeholder="Minimo stock" value="{{session::get('stockminimo')}}">
	@endif
   
  </div>
  
  </div>
  
  </div>
  <div class="row">
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Precio de compra</label>
        @if(Session::get('preciocompra')=="")
      <input type="number" name="preciocompra" class="form-control" id="inputPassword3" placeholder="Precio compra" value="{{$productos->preciocompra}}">
        @else
			<input type="number" name="preciocompra" class="form-control" id="inputPassword3" placeholder="Precio compra" value="{{session::get('preciocompra')}}">
		@endif
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Precio venta</label>
       @if(Session::get('precioventa')=="")
      <input type="number" name="precioventa" class="form-control" id="inputPassword3" placeholder="Precio venta" value="{{$productos->precioventa}}">
      @else
		  <input type="number" name="precioventa" class="form-control" id="inputPassword3" placeholder="Precio venta" value="{{session::get('precioventa')}}">
	  @endif
  
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Precio sugerido</label>
     @if(Session::get('preciosugerido')=="")
      <input type="number" name="preciosugerido" class="form-control" id="inputPassword3" placeholder="Precio sugerido" value="{{$productos->preciosugerido}}">
    @else
		<input type="number" name="preciosugerido" class="form-control" id="inputPassword3" placeholder="Precio sugerido" value="{{session::get('preciosugerido')}}">
   @endif
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Iva %</label>
      <select class="chosen-select form-control" name="iva" id="form-field-select-3" data-placeholder="Seleccione">
																<option value=""> </option>
																
																@foreach($iva as $i)
																@if(Session::get('proveedor')==$i->idiva)
															    <option value="{{$i->idiva}}" selected>{{$i->valoriva}}</option>
															    @else
															    @if($productos->idiva==$i->idiva)
																<option value="{{$i->idiva}}" selected>{{$i->valoriva}}</option>
															    @else
																<option value="{{$i->idiva}}">{{$i->valoriva}}</option>
															    @endif
																@endif
																@endforeach
																
															</select>
     
   
  </div>
  
  </div>
  
  </div>
   <div class="row">
  <div class="col-md-3">
  <div class="form-group">
    
	 <label for="inputPassword3">Stock</label>
    @if(Session::get('stock')=="")
      <input type="number" name="stock" class="form-control" id="inputPassword3" placeholder="stock" value="{{$productos->stock}}">
  @else
	  <input type="number" name="stock" class="form-control" id="inputPassword3" placeholder="stock" value="{{session::get('stock')}}">
  @endif
    
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Categoría</label>
    
 <select class="chosen-select form-control" name="categoria" id="form-field-select-3" data-placeholder="Seleccione">
																<option value=""> </option>
																
																@foreach($categoria as $cat)
																@if(Session::get('categoria')==$cat->idcategoria)
															    <option value="{{$cat->idcategoria}}" selected>{{$cat->descripcioncategoria}}</option>
															    @else
																@if($productos->idcategoria==$cat->idcategoria)
																<option value="{{$cat->idcategoria}}" selected>{{$cat->descripcioncategoria}}</option>
															    @else
																<option value="{{$cat->idcategoria}}">{{$cat->descripcioncategoria}}</option>
															    @endif
																@endif
																@endforeach
																
															</select>
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Proveedor</label>
    
     <select class="chosen-select form-control" name="proveedor" id="form-field-select-3" data-placeholder="Seleccione">
																<option value=""> </option>
																
																@foreach($proveedor as $p)
																@if(Session::get('proveedor')==$p->idproveedor)
															    <option value="{{$p->idproveedor}}" selected>{{$p->nombreproveedor}}</option>
															    @else
															    @if($productos->idproveedor==$p->idproveedor)
																<option value="{{$p->idproveedor}}" selected>{{$p->nombreproveedor}}</option>
															    @else
																<option value="{{$p->idproveedor}}">{{$p->nombreproveedor}}</option>
															    @endif
																@endif
																@endforeach
																
															</select>
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Comision</label>
     @if(Session::get('comision')=="")
      <input type="number" name="comision" class="form-control" id="inputPassword3" placeholder="Comision" value="{{$productos->comision}}">
     @else
		 <input type="number" name="comision" class="form-control" id="inputPassword3" placeholder="Comision" value="{{session::get('comision')}}">
	 @endif
   
  </div>
  
  </div>
  
  </div>
  <div class="row">
  <div class="col-md-3">
  <div class="form-group">
    
	 <label for="inputPassword3">No. Estanteria</label>
    @if(Session::get('estante')=="")
      <input type="number" name="estante" class="form-control" id="inputPassword3" placeholder="estanteria" value="{{$productos->estante}}">
  @else
	  <input type="number" name="estante" class="form-control" id="inputPassword3" placeholder="estanteria" value="{{session::get('estante')}}">
  @endif
    
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Entrepaño</label>
    
@if(Session::get('entrepano')=="")
      <input type="number" name="entrepano" class="form-control" id="inputPassword3" placeholder="entrepaño" value="{{$productos->entrepano}}">
  @else
	  <input type="number" name="entrepano" class="form-control" id="inputPassword3" placeholder="entrepaño" value="{{session::get('entrepano')}}">
  @endif
   
  </div>
  
  </div>
  <div class="col-md-3">
  <div class="form-group">
    <label for="inputPassword3">Principio activo</label>
    
@if(Session::get('principio')=="")
      <input type="text" name="principio" class="form-control" id="inputPassword3" placeholder="Activo principio" value="{{$productos->activo_principio}}">
  @else
	  <input type="text" name="principio" class="form-control" id="inputPassword3" placeholder="Activo principio" value="{{session::get('principio')}}">
  @endif
   
  </div>
  
  </div>
 
 
  
  </div>
  <div class="row">
  <div class="col-md-3">
  <div class="form-group">
   <label class="control-label col-xs-12 col-sm-3">ACTIVO</label>
   @if ($productos->estado==1)
  <input name="estado" class="ace ace-switch" type="checkbox" checked value="1"/>
  
   @else
	     <input name="estado" class="ace ace-switch" type="checkbox"  value="1"/>
	 @endif
  <span class="lbl"></span>
 
  
  </div>
  </div>
  </div>
  

										<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Guardar
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Borrar
											</button>
										</div>
									</div>
				
				
				
				
				{!!Form::close()!!}
				
				</div>
				</div>
					
					
					</div>
					</div>
					</div>
					

@endsection


@section('scripts')

		
		<script src="{{asset('public/js/jquery-2.1.4.min.js')}}"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{asset('public/js/jquery.mobile.custom.min.js')}}>"+"<"+"/script>");
		</script>
		<script src="{{asset('public/js/bootstrap.min.js')}}"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="{{asset('public/js/jquery-ui.custom.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.ui.touch-punch.min.js')}}"></script>
		<script src="{{asset('public/js/chosen.jquery.min.js')}}"></script>
		<script src="{{asset('public/js/spinbox.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-datepicker.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-timepicker.min.js')}}"></script>
		<script src="{{asset('public/js/moment.min.js')}}"></script>
		<script src="{{asset('public/js/daterangepicker.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-colorpicker.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.knob.min.js')}}"></script>
		<script src="{{asset('public/js/autosize.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.inputlimiter.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.maskedinput.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-tag.min.js')}}"></script>

		<!-- ace scripts -->
		<script src="{{asset('public/js/ace-elements.min.js')}}"></script>
		<script src="{{asset('public/js/ace.min.js')}}"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
	
		
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
			
				autosize($('textarea[class*=autosize]'));
				
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
			
			
				
				//"jQuery UI Slider"
				//range slider tooltip example
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1] + "";
			
						if( !ui.handle.firstChild ) {
							$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
							.prependTo(ui.handle);
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('span.ui-slider-handle').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
				
				$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				//pre-show a file name, for example a previously selected file
				//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
			
				$('#id-input-file-3').ace_file_input({
					style: 'well',
					btn_choose: 'Drop files here or click to choose',
					btn_change: null,
					no_icon: 'ace-icon fa fa-cloud-upload',
					droppable: true,
					thumbnail: 'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
				
				//$('#id-input-file-3')
				//.ace_file_input('show_file_list', [
					//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
					//{type: 'file', name: 'hello.txt'}
				//]);
			
				
				
			
				//dynamically change allowed formats by changing allowExt && allowMime function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var whitelist_ext, whitelist_mime;
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "ace-icon fa fa-picture-o";
			
						whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
						whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "ace-icon fa fa-cloud-upload";
						
						whitelist_ext = null;//all extensions are acceptable
						whitelist_mime = null;//all mimes are acceptable
					}
					var file_input = $('#id-input-file-3');
					file_input
					.ace_file_input('update_settings',
					{
						'btn_choose': btn_choose,
						'no_icon': no_icon,
						'allowExt': whitelist_ext,
						'allowMime': whitelist_mime
					})
					file_input.ace_file_input('reset_input');
					
					file_input
					.off('file.error.ace')
					.on('file.error.ace', function(e, info) {
						//console.log(info.file_count);//number of selected files
						//console.log(info.invalid_count);//number of invalid files
						//console.log(info.error_list);//a list of errors in the following format
						
						//info.error_count['ext']
						//info.error_count['mime']
						//info.error_count['size']
						
						//info.error_list['ext']  = [list of file names with invalid extension]
						//info.error_list['mime'] = [list of file names with invalid mimetype]
						//info.error_list['size'] = [list of file names with invalid size]
						
						
						/**
						if( !info.dropped ) {
							//perhapse reset file field if files have been selected, and there are invalid files among them
							//when files are dropped, only valid files will be added to our file array
							e.preventDefault();//it will rest input
						}
						*/
						
						
						//if files have been selected (not dropped), you can choose to reset input
						//because browser keeps all selected files anyway and this cannot be changed
						//we can only reset file field to become empty again
						//on any case you still should check files with your server side script
						//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
					});
					
					
					/**
					file_input
					.off('file.preview.ace')
					.on('file.preview.ace', function(e, info) {
						console.log(info.file.width);
						console.log(info.file.height);
						e.preventDefault();//to prevent preview
					});
					*/
				
				});
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.closest('.ace-spinner')
				.on('changed.fu.spinbox', function(){
					//console.log($('#spinner1').val())
				}); 
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
			
				//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
				//or
				//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
				//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
			
			
				//datepicker plugin
				//link
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});
			
			
				//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
				$('input[name=date-range-picker]').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
			
			
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false,
					disableFocus: true,
					icons: {
						up: 'fa fa-chevron-up',
						down: 'fa fa-chevron-down'
					}
				}).on('focus', function() {
					$('#timepicker1').timepicker('showWidget');
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				
			
				
				if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
				 //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
				 icons: {
					time: 'fa fa-clock-o',
					date: 'fa fa-calendar',
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down',
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right',
					today: 'fa fa-arrows ',
					clear: 'fa fa-trash',
					close: 'fa fa-times'
				 }
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
			
				$('#colorpicker1').colorpicker();
				//$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe
			
				$('#simple-colorpicker-1').ace_colorpicker();
				//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
				//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
				//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
				//picker.pick('red', true);//insert the color if it doesn't exist
			
			
				$(".knob").knob();
				
				
				var tag_input = $('#form-field-tags');
				try{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
						/**
						//or fetch data from database, fetch those that match "query"
						source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
						*/
					  }
					)
			
					//programmatically add/remove a tag
					var $tag_obj = $('#form-field-tags').data('tag');
					$tag_obj.add('Programmatically Added');
					
					var index = $tag_obj.inValues('some tag');
					$tag_obj.remove(index);
				}
				catch(e) {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//autosize($('#form-field-tags'));
				}
				
				
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'ace-icon fa fa-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-form').on('shown.bs.modal', function () {
					if(!ace.vars['touch']) {
						$(this).find('.chosen-container').each(function(){
							$(this).find('a:first-child').css('width' , '210px');
							$(this).find('.chosen-drop').css('width' , '210px');
							$(this).find('.chosen-search input').css('width' , '200px');
						});
					}
				})
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
				
				
				$(document).one('ajaxloadstart.page', function(e) {
					autosize.destroy('textarea[class*=autosize]')
					
					$('.limiterBox,.autosizejs').remove();
					$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
				});
			
			});
		</script>

@endsection