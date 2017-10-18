<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table='gasto';
	
	protected $primaryKey='idgasto';
	
	public $timestamps=false;
	
	protected $fillable=[
	'fecha',
	'descripciongasto',
	'proveedorgasto',
	'valorgasto',
	'estado'
	];
	protected $guarded=[
	
	];
}
