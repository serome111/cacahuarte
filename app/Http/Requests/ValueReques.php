<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValueReques extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'state' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'link' => 'required|url'
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'debes poner el titulo',
            'description.required' => 'debes poner una descripcion',
            'link.url' => 'Debe tener una url valida ejemplo https://cacahuarte.com/mision',
            'link.required' => 'Campo requerido',
            'state.required' => 'deber poner el estado del banner',
            'picture.mimes' => 'debes subir una foto en formato jpg, jpeg o png'
        ];
    }
}
