<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\FiliereImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportFiliereController extends Controller
{
    public function importForm()
    {
        return view('pages.filieres.list-filiere'); // crée une vue simple avec un input file
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10480',
        ], [
            'file.required' => 'Le fichier est requis',
            'file.mimes' => 'Le fichier doit être au format xlsx, xls ou csv',
            'file.max' => 'La taille du fichier ne doit pas excéder 10Mo',
        ]);
        $file = $request->file('file');


        $data = Excel::toArray([], $file);
        $headers = $data[0][0];

        $expectedHeaders = ['name', 'description'];

        foreach ($expectedHeaders as $expectedHeader) {
            if (!in_array($expectedHeader, $headers)) {
                return back()->withErrors([
                    'file' => "Le fichier Excel doit contenir la colonne obligatoire : '$expectedHeader'."
                ]);
            }
        }

        try {
            Excel::import(new FiliereImport, $file);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => "Erreur lors de l'import : " . $e->getMessage()]);
        }
        return back()->with('success', 'Importation réussie !');
    }
}
