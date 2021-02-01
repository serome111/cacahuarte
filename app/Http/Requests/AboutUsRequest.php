<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'photo' => 'mimes:jpg,jpeg,png',
            'link' => 'required',

            'title1' => 'required',
            'description1' => 'required',
            'favicon1' => 'required',

            'title2' => 'required',
            'description2' => 'required',
            'favicon2' => 'required',

            'title3' => 'required',
            'description3' => 'required',
            'favicon3' => 'required'

        ];
    }
     public function messages()
    {
        return[
            'title.required' => 'debes poner el titulo',
            'description.required' => 'debes poner una descripcion',
            'photo.mimes' => 'debes subir una foto en formato jpg, jpeg o png',
            'link.required' => 'Debes poner un link a visualizar',


            'title1.requierd' => 'Debes subir un titulo',
            'description1.required' => 'Debes escribir una descripcion',
            'favicon1.required' => '1: debes subir un icono ',

            'title2.requierd' => 'Debes subir un titulo',
            'description2.required' => 'Debes escribir una descripcion',
            'favicon2.required' => 'debes subir un icono',

            'title3.requierd' => 'Debes subir un titulo',
            'description3.required' => 'Debes escribir una descripcion',
            'favicon3.required' => 'debes subir un icono'

        ];
    }
}
