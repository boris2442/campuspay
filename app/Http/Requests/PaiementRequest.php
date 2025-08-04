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
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'montant_paye' => 'required|numeric|min:1', // Montant libre, positif
            'mode_paiement' => 'required|string|in:espèce,mobile_money,virement', // Valeurs autorisées
            'tranche_paye' => 'nullable|string|max:50', // Optionnel : pour info (ex: "partiel")
        ];
    }

    /**
     * Messages de validation personnalisés.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Veuillez sélectionner un étudiant.',
            'user_id.exists' => 'L\'étudiant sélectionné est invalide.',

            'montant_paye.required' => 'Le montant payé est obligatoire.',
            'montant_paye.numeric' => 'Le montant doit être un nombre.',
            'montant_paye.min' => 'Le montant doit être au moins de 1 FCFA.',

            'mode_paiement.required' => 'Le mode de paiement est obligatoire.',
            'mode_paiement.string' => 'Le mode de paiement doit être une chaîne de caractères.',
            'mode_paiement.in' => 'Le mode de paiement sélectionné est invalide.',

            'tranche_paye.string' => 'Le format de la tranche est invalide.',
            'tranche_paye.max' => 'La tranche ne doit pas dépasser 50 caractères.',
        ];
    }
}