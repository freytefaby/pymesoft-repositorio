<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DevolucionesCompras extends Model
{
    protected $table='devolucioncompra';
	
	protected $primaryKey='iddevolucioncompra';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valordevolucion',
	'idusuario',
	'idproveedor',
	'subtotal',
	'utilidades',
	'idcompra',
	'fecha',
	'estado',
	'observacion'
	
	
	];
	protected $guarded=[
	
	];
}
