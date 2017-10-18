<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class CierreDiario extends Model
{
    protected $table='cierre_diario';
	
	protected $primaryKey='idcierrediario';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valorventa',
	'idusuario',
	'subtotal',
	'comisionventa',
	'utilidades',
	'fecha',
	'fechacierre',
	'base',
	'gastos',
	'estado',
	'recogida'
	
	
	
	];
	protected $guarded=[
	
	];
}
