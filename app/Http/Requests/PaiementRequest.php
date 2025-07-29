<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaiementRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'tranche_paye' => 'required|string|in:tranche1,tranche2,tranche3',
            'mode_paiement' => 'required|string|max:100',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'Le champ étudiant est obligatoire.',
            'user_id.exists' => 'L\'étudiant sélectionné est invalide.',

            'tranche_paye.required' => 'Vous devez sélectionner une tranche.',
            'tranche_paye.string' => 'Le format de la tranche est invalide.',
            'tranche_paye.in' => 'La tranche sélectionnée est invalide.',

            'mode_paiement.required' => 'Le mode de paiement est obligatoire.',
            'mode_paiement.string' => 'Le format du mode de paiement est invalide.',
            'mode_paiement.max' => 'Le mode de paiement est trop long.',
        ];
    }
}
