<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table='perfil';
	
	protected $primaryKey='idperfil';
	
	public $timestamps=false;
	
	protected $fillable=[
	'perfildesc'
	
	];
	protected $guarded=[
	
	];
}
