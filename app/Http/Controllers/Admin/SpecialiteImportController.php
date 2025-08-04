<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SpecialitesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SpecialiteImportController extends Controller
{
    public function form()
    {
        return view('pages.specialites.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ], [
            'file.required' => 'Le fichier est requis',
            'file.mimes' => 'Le fichier doit être au format xlsx, xls ou csv',
            'file.max' => 'La taille du fichier ne doit pas excéder 10Mo',
        ]);

        $file = $request->file('file');

        $data = Excel::toArray([], $file);
        $headers = $data[0][0];

        $expectedHeaders = ['filiere_id', 'name', 'description'];
        foreach ($expectedHeaders as $expectedHeader) {
            if (!in_array($expectedHeader, $headers)) {
                return back()->withErrors([
                    'file' => "Le fichier Excel doit contenir la colonne obligatoire : '$expectedHeader'."
                ]);
            }
        }

        try {
            Excel::import(new SpecialitesImport, $file);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => "Erreur lors de l'import : " . $e->getMessage()]);
        }

        return back()->with('success', 'Importation des spécialités réussie !');
    }
}
