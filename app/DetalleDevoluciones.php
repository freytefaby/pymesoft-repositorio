<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleDevoluciones extends Model
{
    protected $table='detalledevolucioncliente';
	
	protected $primaryKey='iddetalledevolucioncliente';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valor',
	'idproducto',
	'cantidad',
	'subtotal',
	'iddevolucion',
	'utilidad',
	'comision'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
