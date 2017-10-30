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
								Formulario Cupos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Crear nuevo cupo a cliente
								</small>
							</h1>
						</div><!-- /.page-header -->
					
					<div class="row">
							<div class="col-xs-12">
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
								@if(Session::has('mensaje'))
								<div class="row">
								<div class="col-md-12" >
								<div class="alert alert-warning">
								 {!!Session::get('mensaje')!!}
								</div>
								</div>
								</div>
								@endif 
				
                                {!!Form::open(array('url'=>'peticion/cupo','method'=>'POST','autocomplete'=>'off','role'=>'form','class'=>'form-horizontal'))!!}
				
				<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre cliente </label>

										<div class="col-sm-9">
											<input type="text" id="cliente" placeholder="Cedula cliente" class="col-xs-10 col-sm-5" name="client" value="{{old('client')}}" /><div id="cedulacliente"  style="display:none;"><strong id="nombrecliente"></strong></div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Credito maximo </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1-1" placeholder="Credito maximo" class="col-xs-10 col-sm-5" name="valor" value="{{old('valor')}}" />
										</div>
									</div>

                                    <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Maximo plazo de pago en dias  </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1-1" placeholder="Plazo en dias" class="col-xs-10 col-sm-5" name="dias" value="{{old('dias')}}" />
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
                                    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token2">
                                    <input type="hidden" id="idcliente" name="cliente" >
				
				
				
				{!!Form::close()!!}
				
				</div>
				</div>
					
					
					</div>
					</div>
					</div>
					

@endsection


@section('scripts')

		<!--[if !IE]> -->
		<script src="{{asset('public/js/jquery-2.1.4.min.js')}}"></script>

		<!-- <![endif]-->
        <script>
							$("#cliente").blur(function(e){
			
		
			var busqueda = $("#cliente").val();
		    var token=$("#token2").val();
			if(busqueda.lenght <= 0 )
			{
				alert("Es necesario digitar un numero de cedula o identifiaci�n para arrojar datos");
				
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
		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{asset('public/js/jquery.mobile.custom.min.js')}}'>"+"<"+"/script>");
		</script>
		<script src="{{asset('public/js/bootstrap.min.js')}}"></script>

		<!-- page specific plugin scripts -->
		<script src="{{asset('public/js/jquery-ui.custom.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.ui.touch-punch.min.js')}}"></script>
		<script src="{{asset('public/js/markdown.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-markdown.min.js')}}"></script>
		<script src="{{asset('public/js/jquery.hotkeys.index.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap-wysiwyg.min.js')}}"></script>
		<script src="{{asset('public/js/bootbox.js')}}"></script>

		<!-- ace scripts -->
		<script src="{{asset('public/js/ace-elements.min.js')}}"></script>
		<script src="{{asset('public/js/ace.min.js')}}"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
	
	$('textarea[data-provide="markdown"]').each(function(){
        var $this = $(this);

		if ($this.data('markdown')) {
		  $this.data('markdown').showEditor();
		}
		else $this.markdown()
		
		$this.parent().find('.btn').addClass('btn-white');
    })
	
	
	
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			//console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	}

	//$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

	//but we want to change a few buttons colors for the third style
	$('#editor1').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			{name:'outdent', className:'btn-purple'},
			{name:'indent', className:'btn-purple'},
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			{name:'justifyfull', className:'btn-inverse'},
			null,
			{name:'createLink', className:'btn-pink'},
			{name:'unlink', className:'btn-pink'},
			null,
			{name:'insertImage', className:'btn-success'},
			null,
			'foreColor',
			null,
			{name:'undo', className:'btn-grey'},
			{name:'redo', className:'btn-grey'}
		],
		'wysiwyg': {
			fileUploadError: showErrorAlert
		}
	}).prev().addClass('wysiwyg-style2');

	
	/**
	//make the editor have all the available height
	$(window).on('resize.editor', function() {
		var offset = $('#editor1').parent().offset();
		var winHeight =  $(this).height();
		
		$('#editor1').css({'height':winHeight - offset.top - 10, 'max-height': 'none'});
	}).triggerHandler('resize.editor');
	*/
	

	$('#editor2').css({'height':'200px'}).ace_wysiwyg({
		toolbar_place: function(toolbar) {
			return $(this).closest('.widget-box')
			       .find('.widget-header').prepend(toolbar)
				   .find('.wysiwyg-toolbar').addClass('inline');
		},
		toolbar:
		[
			'bold',
			{name:'italic' , title:'Change Title!', icon: 'ace-icon fa fa-leaf'},
			'strikethrough',
			null,
			'insertunorderedlist',
			'insertorderedlist',
			null,
			'justifyleft',
			'justifycenter',
			'justifyright'
		],
		speech_button: false
	});
	
	


	$('[data-toggle="buttons"] .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		var toolbar = $('#editor1').prev().get(0);
		if(which >= 1 && which <= 4) {
			toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
			if(which == 1) $(toolbar).addClass('wysiwyg-style1');
			else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
			if(which == 4) {
				$(toolbar).find('.btn-group > .btn').addClass('btn-white btn-round');
			} else $(toolbar).find('.btn-group > .btn-white').removeClass('btn-white btn-round');
		}
	});


	

	//RESIZE IMAGE
	
	//Add Image Resize Functionality to Chrome and Safari
	//webkit browsers don't have image resize functionality when content is editable
	//so let's add something using jQuery UI resizable
	//another option would be opening a dialog for user to enter dimensions.
	if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {
		
		var lastResizableImg = null;
		function destroyResizable() {
			if(lastResizableImg == null) return;
			lastResizableImg.resizable( "destroy" );
			lastResizableImg.removeData('resizable');
			lastResizableImg = null;
		}

		var enableImageResize = function() {
			$('.wysiwyg-editor')
			.on('mousedown', function(e) {
				var target = $(e.target);
				if( e.target instanceof HTMLImageElement ) {
					if( !target.data('resizable') ) {
						target.resizable({
							aspectRatio: e.target.width / e.target.height,
						});
						target.data('resizable', true);
						
						if( lastResizableImg != null ) {
							//disable previous resizable image
							lastResizableImg.resizable( "destroy" );
							lastResizableImg.removeData('resizable');
						}
						lastResizableImg = target;
					}
				}
			})
			.on('click', function(e) {
				if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
					destroyResizable();
				}
			})
			.on('keydown', function() {
				destroyResizable();
			});
	    }

		enableImageResize();

		/**
		//or we can load the jQuery UI dynamically only if needed
		if (typeof jQuery.ui !== 'undefined') enableImageResize();
		else {//load jQuery UI if not loaded
			//in Ace demo ./components will be replaced by correct components path
			$.getScript("assets/js/jquery-ui.custom.min.js", function(data, textStatus, jqxhr) {
				enableImageResize()
			});
		}
		*/
	}


});
		</script>

@endsection