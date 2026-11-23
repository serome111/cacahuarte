<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $product = $this->route('product');
        $uniqueCode = Rule::unique('products', 'code');
        if ($product instanceof \App\Models\Products) {
            $uniqueCode->ignore($product);
        }

        return [
            'code' => ['required', 'string', 'max:255', $uniqueCode],
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'categorie_id' => 'required',
            'state' => 'required',
            'picture' => [$this->isMethod('POST') ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'extensions:jpg,jpeg,png', 'max:5120'],
            'description' => 'required'
        ];
    }
    public function messages()
    {
        return[
            'code.unique' => 'Ya existe un producto con ese código.',
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
