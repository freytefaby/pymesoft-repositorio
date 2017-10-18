<div class="modal fade bs-example-modal-lg" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Busqueda instantanea de productos</h4>
      </div>
      <div class="modal-body">
      
	<input type="text" class="form-control" name="p" id="search"  placeholder="Codigo de barras o nombre de producto">
		<br>
		 <div class="alert alert-warning" id="error" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">x</button>
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong id="mensaje" >Argumento no valido.</strong> 
            </div>
<div style="display:none" id="cargador">
												<h3 class="header smaller lighter grey">
													<i class="ace-icon fa fa-spinner fa-spin blue bigger-125"></i>
													Buscando productos
													
												</h3>
											</div>
<div id="response"></div>		
														
      </div>
     
    </div>

  </div>
</div>