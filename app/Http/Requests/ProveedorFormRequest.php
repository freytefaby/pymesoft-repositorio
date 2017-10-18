<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class ProveedorFormRequest extends Request
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
            'proveedor'=>'required',
			'nit'=>'required',
			'celular'=>'required|numeric',
			'direccion'=>'required',
			'apellidorepresentante'=>'required',
			'representante'=>'required',
			
			 
        ];
    }
}
