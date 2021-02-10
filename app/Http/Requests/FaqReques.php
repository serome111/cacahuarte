<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqReques extends FormRequest
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
            'question' => 'required',
            'solution' => 'required',
            'link' => 'required',
            'textLink' => 'required'
        ];
    }
     public function messages()
    {
        return[
            'question.required' => 'debes poner la pregunta frecuente',
            'solution.required' => 'debes poner una descripcion o resolver la pregunta',
            'link.required' => 'falta un enlace',
            'textLink.required' => 'falta el texto del enlace'
        ];
    }
}
