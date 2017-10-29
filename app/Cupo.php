<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Cupo extends Model
{
    protected $table='cupo';
	
	protected $primaryKey='idconvenio';
	
	public $timestamps=false;
	
	protected $fillable=[
    'idcliente',
	'max_credito',
	'fecha_creacion_convenio',
	'dias_credito'
	
	
	
	
	];
	protected $guarded=[
	
	];
}
