<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class InfoEmpresaFormRequest extends Request
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
            'telefonoempresa'=>'required|numeric',
			'direccionempresa'=>'required',
			'nombrepropietario'=>'required',
			'apellidopropietario'=>'required',
			'telefonopropietario'=>'required|numeric',
			'nitempresa'=>'required',
			'nombrecomercialempresa'=>'required',
			'ciudadempresa'=>'required',
			 
        ];
    }
}
