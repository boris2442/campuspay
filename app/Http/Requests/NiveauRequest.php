<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NiveauRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255|unique:niveaux,name,except,id',
            'specialite_id' => 'required|exists:specialites,id',
        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'Le nom est requis ',
            'name.string' => 'Le nom doit etre une chaine de caracteres',
            'name.max' => 'Le nombre de caracteres ne doit pas exceder 255 caracteres',
            'name.unique' => 'Le niveau doit etre unique',
            'specialite_id.required' => 'La spécialité est requise.',
            'specialite_id.exists' => 'La spécialité sélectionnée est invalide.',
        ];
    }
}
