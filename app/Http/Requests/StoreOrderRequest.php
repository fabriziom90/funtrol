<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'exists:suppliers,id'],

            'products' => ['required', 'array', 'min:1'],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
                // evita duplicati nello stesso ordine
                'distinct'
            ],

            // SEMPRE in grammi
            'products.*.quantity' => [
                'required',
                'numeric',
                'min:1'
            ],

            // prezzo UNITARIO al kg
            'products.*.unit_price' => [
                'required',
                'numeric',
                'min:0'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'Devi inserire almeno un prodotto',
            'products.*.quantity.min' => 'La quantità deve essere maggiore di 0',
            'products.*.unit_price.min' => 'Il prezzo non può essere negativo',
            'products.*.product_id.distinct' => 'Lo stesso prodotto non può comparire due volte',
        ];
    }
}
