<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'rol' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'Falta nombre',
            'rol.required' => 'Falta seleccionar un rol',
            'email.required' => 'Falta correo',
            'password.required' => 'Falta contraseña'
        ];
    }
}
