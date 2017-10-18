<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class DetalleConvenio extends Model
{
    protected $table='detalle_convenio';
	
	protected $primaryKey='iddetalleconvenio';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idconvenio',
	'facturascadena',
	'valorconvenio'
	
	
	
	
	];
	protected $guarded=[
	
	];
}