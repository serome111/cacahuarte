<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
            'nombre' => 'required',
            'apellido' => 'required',
            'cargo' => 'required',
            'estado' => 'required',
            'imagen' => 'mimes:jpg,jpeg,png'
        ];
    }


    public function messages()
    {
        return [

            'nombre.required' => 'El nombre del integrante es requerido',
            'nombre.required' => 'El nombre del integrante es requerido',
            'cargo.required' => 'El cargo del integrante es requerido',
            'estado.required' => 'El estado del integrante es requerido',
            'imagen.mimes' => 'debes subir una foto en formato jpg, jpeg o png'
        ];
    }
}
