@extends('layouts.template_login')

@section('content')

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-medkit blue"></i>
									<span class="red">..::Pymesoft.LTE::..</span>
									<span class="white" id="id-text2">Application</span>
								</h1>
								
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Login de acceso al sistema
											</h4>

											<div class="space-6"></div>

											{!! Form::open(array('url'=>'peticion/verificar_login','name'=>'form'))!!}
												<fieldset>
												 @if(Session::has('mensaje'))
                                     <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                             <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{Session::get('mensaje')}}.
                                         </div>
                                          @endif
										  @if (count($errors)>0)
								                    
								                  
								                     <div class="alert alert-danger">
													  <button type="button" class="close" data-dismiss="alert">x</button>
								                     <ul>
								                @foreach ($errors->all() as $error)
								                    <li >{{$error}}</li>
								               @endforeach
								                    </ul>
								                    </div>
								                   
								                    
								               @endif
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" name="user" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" name="pass"/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label>

														<button  type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
												{!! Form::close() !!}

											
										</div><!-- /.widget-main -->

										
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								

								
							</div><!-- /.position-relative -->

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

@endsection		