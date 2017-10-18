<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Devoluciones extends Model
{
    protected $table='devolucionescliente';
	
	protected $primaryKey='iddevolucioncliente';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valordevolucion',
	'idusuario',
	'idcliente',
	'subtotal',
	'utilidades',
	'idventa',
	'fecha',
	'estado',
	'observacion',
	'comision'
	
	
	];
	protected $guarded=[
	
	];
}
