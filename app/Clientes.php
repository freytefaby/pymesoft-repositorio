<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table='clientes';
	
	protected $primaryKey='idcliente';
	
	public $timestamps=false;
	
	protected $fillable=[
	'nombrecliente',
	'apellidocliente',
	'direccioncliente',
	'telefonocliente',
	'cedulacliente'
	];
	protected $guarded=[
	
	];
}
