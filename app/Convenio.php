<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table='convenio';
	
	protected $primaryKey='idconvenio';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idcliente',
	'valorconvenio',
	'fechaconvenio',
	'estadoconvenio',
	'abono',
	'dias_cupo',
	'valor_maximo'
	
	
	
	];
	protected $guarded=[
	
	];
}
