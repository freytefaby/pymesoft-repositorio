<?php

namespace hhfarm;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table='producto';
	
	protected $primaryKey='idproducto';
	
	public $timestamps=false;
	
	protected $fillable=[
	'descripcionproducto',
	'codigobarra1',
	'codigobarra2',
	'codigobarra3',
	'codigobarra4',
	'cantidadempaque',
	'stock',
	'stockminimo',
	'preciocompra',
	'precioventa',
	'preciosugerido',
	'idiva',
	'idtipoproducto',
	'idcategoria',
	'idproveedor',
	'estado',
	'comision',
	'estante',
	'entrepano',
	'activo_principio'
	];
	protected $guarded=[
	
	];
public function scopeProducto($query,$name)
{
	return $query->where('descripcionproducto','LIKE',"%$name%");
}
public function scopeCodigo($query,$codigo)
{
	return $query->where('codigobarra1',$codigo)
	             ->orwhere('codigobarra2',$codigo)
				 ->orwhere('codigobarra3',$codigo)
				 ->orwhere('codigobarra4',$codigo);
}
public function scopeProveedor($query,$proveedor)
{
	return $query->orwhere('idproveedor',$proveedor);
}

}
