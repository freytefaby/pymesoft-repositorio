<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Iva extends Model
{
    protected $table='iva';
	
	protected $primaryKey='idiva';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valoriva'
	
	];
	protected $guarded=[
	
	];
}
