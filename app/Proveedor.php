<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table='proveedor';
	
	protected $primaryKey='idproveedor';
	
	public $timestamps=false;
	
	protected $fillable=[
	'nombreproveedor',
	'nitproveedor',
	'nombrepropietarioproveedor',
	'apellidopropietarioproveedor',
	'celularproveedor',
	'direccionproveedor'
	];
	protected $guarded=[
	
	];
}
