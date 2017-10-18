<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class InfoEmpresa extends Model
{
    protected $table='infoempresa';
	
	protected $primaryKey='idinfoempresa';
	
	public $timestamps=false;
	
	protected $fillable=[
	'telefonoempresa',
	'direccionempresa',
	'nombrepropietario',
	'apellidopropietario',
	'telefonopropietario',
	'nitempresa',
	'nombrecomercialempresa',
	'ciudadempresa'
	];
	protected $guarded=[
	
	];
}
