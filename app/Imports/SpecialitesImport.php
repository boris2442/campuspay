<?php

namespace App\Imports;

use App\Models\Specialite;
use Maatwebsite\Excel\Concerns\ToModel;

class SpecialitesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Specialite([
            'filiere_id' => $row['filiere_id'],
            'name' => $row['name'],
            'description' => $row['[description'] ?? '',
        ]);
    }
}
