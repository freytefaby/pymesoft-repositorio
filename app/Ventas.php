<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table='venta';
	
	protected $primaryKey='idventa';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valorventa',
	'idusuario',
	'idcliente',
	'subtotal',
	'comisionventa',
	'utilidades',
	'fecha',
	'estado',
	'idtipoventa',
	'descuento',
	'comision',
	'devolucion',
	'comision_devolucion',
	'utilidades_devolucion',
	'convenio'
	
	
	];
	protected $guarded=[
	
	];
}
