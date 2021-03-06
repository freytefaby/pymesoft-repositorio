<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class VentaForRequest extends Request
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
			'cliente'=>'required',
			'tipoventa'=>'required|numeric',
			'valor'=>'required|numeric',
			'descuento'=>'numeric',
			
			
        ];
    }
}
