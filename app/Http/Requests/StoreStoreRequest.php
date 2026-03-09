<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'store.name' => ['required', 'string', 'max:255'],
            'store.owner_name' => ['required', 'string', 'max:255'],
            'store.email' => ['required', 'email', 'max:255'],

            'user.email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'user.password' => ['required', 'string', 'min:8']
        ];
    }

    public function messages(): array
    {
        return [
            'store.name.required' => 'Il nome del negozio è obbligatorio.',
            'store.owner_name.required' => 'Il nome del proprietario è obbligatorio.',
            'store.email.required' => 'L\'email del negozio è obbligatoria.',
            'store.email.email' => 'Inserisci un\'email valida.',

            'user.email.required' => 'L\'email dell\'account è obbligatoria.',
            'user.email.email' => 'Inserisci un\'email valida.',
            'user.email.unique' => 'Questa email è già registrata.',
            'user.password.required' => 'La password è obbligatoria.',
            'user.password.min' => 'La password deve contenere almeno 8 caratteri.',
        ];
    }
}
