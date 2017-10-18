<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleVentas extends Model
{
    protected $table='detalleventa';
	
	protected $primaryKey='iddetalleventa';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valor',
	'idproducto',
	'cantidad',
	'subtotal',
	'idventa',
	'utilidad',
	'comision'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
