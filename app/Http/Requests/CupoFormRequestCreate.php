<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class CupoFormRequestCreate extends Request
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
            'cliente'=>'required|numeric',
            'valor'=>'required|numeric',
            'dias'=>'required|numeric|min:1',
			
			
        ];
    }
}
