<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\Hash;


class EtudiantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts

{
    use SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'               => $row['name'],
            'prenom'             => $row['prenom'],
            'email'              => $row['email'],
            'sexe'               => $row['sexe'],
            'date_naissance'     => $row['date_naissance'],
            'lieu_de_naissance'  => $row['lieu_de_naissance'],
            'telephone' => isset($row['telephone']) ? (string) $row['telephone'] : null,

            'adresse'            => $row['adresse'],
            'filiere_id'         => $row['filiere_id'],
            'specialite_id'      => $row['specialite_id'],
            'niveau_id'          => $row['niveau_id'],
            'photo'              => $row['photo'] ?? null,
            'role'               => 'user',
            'password'           => Hash::make('12345678'),
        ]);
    }
    public function rules(): array
    {
        return [
            '*.name'              => 'required|string|max:255',
            '*.prenom'            => 'required|string|max:255',
            '*.email'             => 'required|email|max:255|unique:users,email',
            '*.sexe'              => 'required|in:Masculin,Feminin',
            '*.date_naissance'    => 'nullable|date',
            '*.telephone'         => 'nullable|string|max:55',
            '*.adresse'           => 'nullable|string|max:255',
            '*.lieu_de_naissance' => 'required|string|max:255',
            '*.filiere_id'        => 'required|exists:filieres,id',
            '*.specialite_id'     => 'required|exists:specialites,id',
            '*.niveau_id'         => 'required|exists:niveaux,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'email.required' => "L'email est requis.",
            'email.email' => "L'email doit être une adresse valide.",
            'email.unique' => "L'email :input existe déjà.",
            'sexe.required' => 'Le sexe est requis.',
            'sexe.in' => 'Le sexe doit être Masculin ou Feminin.',
            'lieu_de_naissance.required' => 'Le lieu de naissance est requis.',
            'filiere_id.required' => 'La filière est requise.',
            'filiere_id.exists' => 'Filière invalide.',
            'specialite_id.required' => 'La spécialité est requise.',
            'specialite_id.exists' => 'Spécialité invalide.',
            'niveau_id.required' => 'Le niveau est requis.',
            'niveau_id.exists' => 'Niveau invalide.',
        ];
    }

    public function batchSize(): int // indique à Laravel Excel de traiter les données par lots de 100 lignes à la fois lors de l’import.
    {
        return 100;
    }
}
