<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecepyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],

            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.product_id' => ['required', 'exists:products,id'],
            'ingredients.*.grams' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome della ricetta è obbligatorio.',
            'name.string' => 'Il nome deve essere una stringa valida.',
            'name.max' => 'Il nome può contenere massimo 255 caratteri.',

            'description.string' => 'La descrizione deve essere testuale.',

            'price.required' => 'Il prezzo è obbligatorio.',
            'price.numeric' => 'Il prezzo deve essere numerico.',
            'price.min' => 'Il prezzo non può essere negativo.',

            'ingredients.required' => 'Devi inserire almeno un ingrediente.',
            'ingredients.array' => 'Gli ingredienti devono essere un array.',
            'ingredients.min' => 'Serve almeno un ingrediente per la ricetta.',

            'ingredients.*.product_id.required' => 'Ogni ingrediente deve avere un prodotto.',
            'ingredients.*.product_id.exists' => 'Uno degli ingredienti fa riferimento a un prodotto inesistente.',

            'ingredients.*.grams.required' => 'Ogni ingrediente deve indicare i grammi.',
            'ingredients.*.grams.integer' => 'I grammi devono essere un numero intero.',
            'ingredients.*.grams.min' => 'I grammi devono essere almeno 1.',
        ];
    }
}
