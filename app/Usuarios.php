<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table='usuarios';
	
	protected $primaryKey='idusuario';
	
	public $timestamps=false;
	
	protected $fillable=[
	'idperfil',
	'nombreusuario',
	'apellidousuario',
	'telefonousuario',
	'cedulausuario',
	'cuotausuario',
	'contrasena',
	'user',
	'estado',
	'imagen'
	];
	protected $guarded=[
	
	];
}
