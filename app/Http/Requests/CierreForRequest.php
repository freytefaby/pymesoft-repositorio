<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class CierreForRequest extends Request
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
			'fecha'=>'required|date',
			'recogida'=>'required|min:1',
			'ventas'=>'required|min:1',
			'subtotal'=>'required|min:1',
			'utilidades'=>'required|min:1',
			
			
			
        ];
    }
}
