<?php

namespace App\Imports;

use App\Models\Filiere;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // <--- important !
class FiliereImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Filiere([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
        ]);
    }
}
