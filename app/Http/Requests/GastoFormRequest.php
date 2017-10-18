<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class GastoFormRequest extends Request
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
           
			'descripcion'=>'required|max:400',
			'proveedor'=>'required|max:50',
			'valor'=>'required|max:400',
			 
        ];
    }
}
