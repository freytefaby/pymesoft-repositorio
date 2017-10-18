<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table='compras';
	
	protected $primaryKey='idcompra';
	
	public $timestamps=false;
	
	protected $fillable=[
	'numfactura',
	'valorcompra',
	'subtotalcompra',
	'idproveedor',
	'utilidadcompra',
	'idusuario',
	'estado',
	'fecha'
	
	
	
	];
	protected $guarded=[
	
	];
}
