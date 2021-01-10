<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTarjetasRequest extends FormRequest
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
            'icon_id' => 'required', 
            'title' => 'required', 
            'description' => 'required',
            'state' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'icon_id.required' => 'Debes selccionar un ícono',
            'title.required'  => 'El título es requerido',
            'description.required'  => 'La descripción es requerida',
            'state.required'  => 'Debes seleccionar un estado'
        ];
    }
}
