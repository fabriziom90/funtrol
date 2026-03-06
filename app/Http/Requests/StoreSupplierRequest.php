<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:suppliers,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'store_id' => ['required', 'exists:stores,id']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome è obbligatorio.',
            'name.string'   => 'Il nome deve essere una stringa valida.',
            'name.max'      => 'Il nome non può superare i 255 caratteri.',

            'email.email'   => "L'indirizzo email non è valido.",
            'email.max'     => "L'indirizzo email non può superare i 255 caratteri.",
            'email.unique'  => "Esiste già un fornitore con questa email.",

            'phone.string'  => 'Il numero di telefono deve essere una stringa.',
            'phone.max'     => 'Il numero di telefono non può superare i 20 caratteri.',

            'store_id.required' => 'Il negozio è obbligatorio.',
            'store_id.exists' => 'Il negozio selezionato non esiste.',
        ];
    }
}
