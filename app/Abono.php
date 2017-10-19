<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $table='detalle_abono';
	
	protected $primaryKey='iddetalleabono';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valorabono',
	'fecha_abono',
	'idcliente',
	'idconvenio'
	
	
	
	];
	protected $guarded=[
	
	];
}
