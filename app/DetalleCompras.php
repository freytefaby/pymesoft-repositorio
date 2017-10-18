<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleCompras extends Model
{
    protected $table='detallecompra';
	
	protected $primaryKey='iddetallecompra';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idcompra',
	'idproducto',
	'valorcompra',
	'utilidadcompra',
	'subtotalcompra',
	'cantidad'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
