<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table='base_caja';
	
	protected $primaryKey='idbasecaja';
	
	public $timestamps=false;
	
	protected $fillable=[
	'valorbase'
	];
	protected $guarded=[
	
	];
}
