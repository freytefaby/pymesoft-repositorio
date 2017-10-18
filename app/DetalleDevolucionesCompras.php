<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleDevolucionesCompras extends Model
{
    protected $table='detalledevolucioncompra';
	
	protected $primaryKey='iddetalledevolucioncompra';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valor',
	'idproducto',
	'cantidad',
	'subtotal',
	'idcompra',
	'utilidad'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
