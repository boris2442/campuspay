<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\EtudiantsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
class ImportEtudiantController extends Controller
{
    // public function importForm()
    // {
    //     return view('pages.users.list-user');
    // }
public function importForm()
{
    $students = User::with(['filiere', 'specialite', 'niveau'])
        ->where('role', 'user')
        ->paginate(10);

    $totalEtudiants = User::where('role', 'user')->count();

    return view('pages.users.list-user', [
        'students' => $students,
        'totalEtudiants' => $totalEtudiants,
        'filtre' => null, // <- Ajout essentiel pour éviter l'erreur
    ]);
}

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'Le fichier est requis.',
            'file.mimes' => 'Le fichier doit être de type xlsx, xls ou csv.',
            'file.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);

        $file = $request->file('file');

        // Vérification des entêtes
        $data = Excel::toArray([], $file);
        $headers = $data[0][0] ?? [];

        $expectedHeaders = [
            'name', 'prenom', 'email', 'sexe', 'date_naissance',
            'lieu_de_naissance', 'telephone', 'adresse',
            'filiere_id', 'specialite_id', 'niveau_id'
        ];

        foreach ($expectedHeaders as $header) {
            if (!in_array($header, $headers)) {
                return back()->withErrors([
                    'file' => "Le fichier doit contenir la colonne : '$header'"
                ]);
            }
        }

        // Lancement de l'import
        $import = new EtudiantsImport();
        Excel::import($import, $file);

        if ($import->failures()->isNotEmpty()) {
            return back()->with([
                'failures' => $import->failures(),
                'success' => 'Import terminé avec des erreurs sur certaines lignes.',
            ]);
        }

        return back()->with('success', 'Importation des étudiants réussie !');
    }
}
