<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Notacredito extends Model
{
    protected $table='notacredito';
	
	protected $primaryKey='idnotacredito';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idcliente',
	'valornotacredito',
	'subtotal',
	'utilidades',
	'fecha',
	'observaciones',
	'idusuario',
	'estado'
	
	
	];
	protected $guarded=[
	
	];
}
