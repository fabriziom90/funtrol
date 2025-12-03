<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'price' => ['required', 'numeric', 'min:0'],
            'grams_in_warehouse' => ['required', 'integer', 'min:0'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome del prodotto è obbligatorio.',
            'name.string' => 'Il nome deve essere una stringa.',
            'name.max' => 'Il nome non può superare 255 caratteri.',

            'price.required' => 'Il prezzo è obbligatorio.',
            'price.numeric' => 'Il prezzo deve essere un numero.',
            'price.min' => 'Il prezzo non può essere negativo.',

            'grams_in_warehouse.required' => 'I grammi in magazzino sono obbligatori.',
            'grams_in_warehouse.integer' => 'I grammi devono essere un numero intero.',
            'grams_in_warehouse.min' => 'I grammi non possono essere negativi.',

            'supplier_id.required' => 'Il fornitore è obbligatorio.',
            'supplier_id.exists' => 'Il fornitore selezionato non esiste.',
        ];
    }
}
