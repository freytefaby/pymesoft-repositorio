<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class ProductosFormRequestUpdate extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'producto'=>'required',
			'codigobarra1'=>'required',
			'tipoproducto'=>'required',
			'cantidadempaque'=>'required_if:tipoproducto,2',
			'stockminimo'=>'required',
			'preciocompra'=>'required',
			'precioventa'=>'required',
			'preciosugerido'=>'required',
			'iva'=>'required',
			'categoria'=>'required',
			'proveedor'=>'required',
			
			
        ];
    }
}
