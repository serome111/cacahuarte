<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReques extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'categorie_id' => 'required',
            'state' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'description' => 'required'
        ];
    }
    public function messages()
    {
        return[
            'code.required' => 'Debes poner un codigo',
            'name.required' => 'Debes poner un nombre',
            'price.required' => 'Debes poner un precio',
            'stock.required' => 'Debes poner una cantidad de inventario',
            'categorie_id.required' => 'Debes seleccionar una categoria',
            'state.required' => 'Debes seleccionar un estado',
            'picture.mimes' => 'Debes subir un formato valido',
            'description.required' => 'Debes poner una descripcion del producto'
        ];
    }
}
