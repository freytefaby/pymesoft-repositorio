<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleNotaCredito extends Model
{
    protected $table='detallenotacredito';
	
	protected $primaryKey='iddetallenotacredito';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idproducto',
	'cantidad',
	'valor',
	'subtotal',
	'utilidades',
	'idnotacredito'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
