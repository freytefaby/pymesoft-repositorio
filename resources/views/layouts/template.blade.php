<!DOCTYPE html>
<html lang="en">
	<head>
	@yield('graficas')
		<meta name="description" content="FACTURACION POS" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<title>@yield('title','..::PYMESOFT LTE::..')</title>
		<link rel="shortcut icon" href="{{asset('public/images/logo/1_Primary_logo_on_transparent_127x74.png')}}" /> 
		<link rel="stylesheet" href="{{asset('public/css/jquery-ui.custom.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/chosen.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/bootstrap-datepicker3.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/bootstrap-timepicker.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/daterangepicker.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/bootstrap-datetimepicker.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/bootstrap-colorpicker.min.css')}}" />
       <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/fonts.googleapis.com.css')}}" />
       <link rel="stylesheet" href="{{asset('public/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
       <link rel="stylesheet" href="{{asset('public/css/ace-skins.min.css')}}" />
		<link rel="stylesheet" href="{{asset('public/css/ace-rtl.min.css')}}" />

		
		<script src="{{asset('public/js/ace-extra.min.js')}}"></script>
	</head>

	<body class="no-skin" onload="recarga();">
		<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="{{URL('peticion/ventas')}}" class="navbar-brand">
						<small>
							
							..::pymesoft LTE::..
						</small>
					</a>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<img src="{{asset('public/images/usuarios/'.Session::get('img'))}}" alt="{{Session::get('user')}}"  />
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">
						

						<li class="light-blue dropdown-modal user-min">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="{{asset('public/images/usuarios/'.Session::get('img'))}}" alt="{{Session::get('user')}}" />
								<span class="user-info">
									<small>Welcome,</small>
									{{session::get('user')}}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="{{url('peticion/restablecer/'.Session::get('id'))}}">
										<i class="ace-icon fa fa-cog"></i>
										Contraseñas
									</a>
								</li>

								<li>
									<a href="{{URL::action('UsuariosController@edit',Session::get('id'))}}">
										<i class="ace-icon fa fa-user"></i>
										Usuario
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="{{URL('peticion/salir')}}">
										<i class="ace-icon fa fa-power-off"></i>
										Cerrar sesion
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				

				<ul class="nav nav-list">
				@if(Session::get('perfil')==1)
				<li class="hover">
						<a href="#" class="dropdown-toggle">
							 <i class="menu-icon fa fa-credit-card"></i>
							<span class="menu-text"> Ventas </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						<li class="">
								<a href="{{URL('peticion/ventas')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Ventas
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/clientes')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Clientes
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/notascredito')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Notas a credito
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{URL('peticion/devoluciones')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Devoluciones Clientes
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="" class="dropdown-toggle">
									<i class="menu-icon fa fa-caret-right"></i>
									Convenios
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>
								<ul class="submenu">
									<li class="">
										<a href="{{URL('peticion/convenio')}}">
											
											Abonos
										</a>

										<b class="arrow"></b>
									</li>
									</ul>
							</li>
							<li class="">
								<a href="{{URL('peticion/graficos')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Graficos
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="hover">
						<a href="#" class="dropdown-toggle">
							 <i class="menu-icon fa fa-cart-arrow-down"></i>
							<span class="menu-text"> Compras </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						<li class="">
								<a href="{{URL('peticion/compras')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Compras
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/sugeridos')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Sugeridos
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/proveedores')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Proveedores
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/iva')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Iva
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{URL('peticion/devolucionescompras')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Devoluciones Compras
								</a>

								<b class="arrow"></b>
							</li>
							
							
						</ul>
					</li>
					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Inventarios </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li >
								<a href="{{URL('peticion/inventarioproductolaboratorio')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Laboratorios
								</a>

								<b class="arrow"></b>
							</li>
							<li >
								<a href="{{URL('peticion/productos')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Productos
								</a>

								<b class="arrow"></b>
							</li>
							<li >
								<a href="{{URL('peticion/categoria')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Categorias
								</a>

								<b class="arrow"></b>
							</li>
							<li >
								<a href="{{URL('peticion/movimientos')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Movimientos
								</a>

								<b class="arrow"></b>
							</li>
							<li >
								<a href="http://hhfarm.biz/webservice/cliente/medicfar/index.php" target="_blank">
									<i class="menu-icon fa fa-caret-right"></i>
									Red de Droguerías
								</a>

								<b class="arrow"></b>
							</li>
							
							</ul>
					</li>
					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text"> Sistema </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{URL('peticion/infoempresa')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Propierario empresa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
									<a href="{{URL('peticion/usuarios')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Usuarios
								</a>

								<b class="arrow"></b>
							</li>

							
							
							
							
							

							

							
						</ul>
					</li>
					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cc" aria-hidden="true"></i>
							<span class="menu-text">Contabilidad </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{URL('peticion/cierrediario')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Cierre contable diario
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
									<a href="{{URL('peticion/reportemes')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Reporte Mes
								</a>

								<b class="arrow"></b>
							</li>

							
							
							
							<li class="">
								<a href="{{URL('peticion/base')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Base
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{URL('peticion/gasto')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Gastos
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="{{URL('peticion/ingreso')}}">
									<i class="menu-icon fa fa-caret-right"></i>
									Otros Ingresos
								</a>

								<b class="arrow"></b>
							</li>

							

							

							
						</ul>
					</li>
					@endif
				</ul><!-- /.nav-list -->
			</div>

			
						

						<!--INICIO SECCION DE CONSTRUCCION-->
			@yield('content')
			<!--FINAL CONSTRUCCION-->

						
					

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">HHSOFTWARE</span>
							..::Pymesoft.LTE::.. &copy; 2017 todos los derechos de autor reservados
						</span>

						
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		@yield('scripts')
	</body>
</html>
