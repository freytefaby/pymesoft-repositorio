<?php

namespace hhfarm\Http\Requests;

use hhfarm\Http\Requests\Request;

class UsuariosFormRequest extends Request
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
			'perfiles'=>'required|numeric',
			'nombre'=>'required',
			'apellido'=>'required',
			'telefono'=>'required|numeric',
			'cedula'=>'required|numeric',
			'contrasena'=>'required',
			'contrasena2'=>'required|min:6',
			'usuario'=>'required|min:6',
			'foto'=>'mimes:jpeg,bmp,png',
			
			
        ];
    }
}
