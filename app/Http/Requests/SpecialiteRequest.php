<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialiteRequest extends FormRequest
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
            // 'name' => 'required|string|max:255|unique:specialites,name,except,id',
            // 'name' => 'required|string|max:255|unique:specialites,name',
            'name' => 'required|string|max:255|unique:specialites,name,' . $this->route('id'),
            'description' => 'nullable|string',
            'filiere_id' => 'required|exists:filieres,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la spécialité est requis.',
            'name.string' => 'Le nom de la spécialité doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la spécialité ne peut pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'name.unique' => 'Le nom de la specialité doit etre unique',
            'filiere_id.required' => 'La filière est requise.',
            'filiere_id.exists' => 'La filière sélectionnée est invalide.',
        ];
    }
}
