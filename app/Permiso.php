<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table='permiso';
	
	protected $primaryKey='idpermiso';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idrecurso',
	'idrol',
	'leer',
	'crear',
	'fecha',
	'eliminar',
	'modificar'

	
	
	];
	protected $guarded=[
	
	];
}
