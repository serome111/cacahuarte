<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'nombreAlmacen' => 'required',
            'nombreRepresentante' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'imagen' => 'mimes:jpg,jpeg,png',
            'departamento' => 'required',
            'ciudad' => 'required',
            'estado' => 'required'
        ];
    }

    public function messages()
    {
        return [

            'nombreAlmacen.required' => 'El nombre del almacén es requerido',
            'nombreRepresentante.required' => 'El nombre del representante es requerido',
            'correo.required' => 'El correo del cliente es requerido',
            'telefono.required' => 'El teléfono del cliente es requerido',
            'imagen.mimes' => 'debes subir una foto en formato jpg, jpeg o png',
            'departamento.required' => 'El departamento es requerido',
            'ciudad.required' => 'La ciudad es requerida',
            'estado.required' => 'Debe seleccionar un estado'
        ];
    }
}
