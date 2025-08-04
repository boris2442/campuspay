<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\NiveauxImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportNiveauController extends Controller
{
    public function importForm()
    {
        return view('pages.niveaux.list-niveau');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $data = Excel::toArray([], $request->file('file'));
        $headers = $data[0][0] ?? [];

        $expectedHeaders = ['name', 'description'];
        foreach ($expectedHeaders as $header) {
            if (!in_array($header, $headers)) {
                return back()->withErrors(['file' => "Colonne '$header' manquante."]);
            }
        }

        $import = new NiveauxImport();
        Excel::import($import, $request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            return back()->with([
                'failures' => $import->failures(),
                'success' => 'Import partiel effectué. Certaines lignes contiennent des erreurs.'
            ]);
        }

        return back()->with('success', 'Importation des niveaux réussie !');
    }
}
