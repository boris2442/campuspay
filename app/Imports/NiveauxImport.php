<?php

namespace App\Imports;

use App\Models\Niveau;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class NiveauxImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Niveau([
            'name' => $row['name'],
            'specialite_id' => $row['specialite_id'],
            // 'created_at' => $row['created_at'] ?? now(),
            // 'updated_at' => $row['updated_at'] ?? now(),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255|unique:niveaux,name',
            '*.specialite_id' => 'required|exists:specialites,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Le nom du niveau est requis.',
            'name.unique' => 'Le niveau ":input" existe déjà.',
            'specialite_id.required' => 'L\'ID de la spécialité est requis.',
            'specialite_id.exists' => 'La spécialité sélectionnée est invalide.',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }
}
