<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$pro->idproducto}}">
	{{Form::open(array('action'=>array('ProductosController@destroy',$pro->idproducto),'method'=>'delete'))}}
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="close">
	<span aria-hidden="true">X</span>
	</button>
	<H4 class="modal-title">Desactiva Producto</h4>
	
	</div>
	<div class="modal-body">
	<p>Desea realmente desactivar producto?</p>
	
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<button type="submit" class="btn btn-danger" >Confirmar</button>
	</div>
	</div>
	</div>
	
	{{Form::close()}}
</div>