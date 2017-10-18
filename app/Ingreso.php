<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='otro_ingreso';
	
	protected $primaryKey='idingreso';
	
	public $timestamps=false;
	
	protected $fillable=[
	'fecha',
	'descripcioningreso',
	'proveedoringreso',
	'valoringreso',
	'utilidadingreso',
	'estado'
	];
	protected $guarded=[
	
	];
}
