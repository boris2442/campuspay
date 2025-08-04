<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filiere;
// use Barryvdh\DomPDF\PDF;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialiteRequest;
use PDF;

class SpecialiteController extends Controller
{
    //
    public function create()
    {
        $filieres = Filiere::all();
        return view('pages.specialites.add-specialite', compact('filieres'));
    }
    public function store(SpecialiteRequest $request)
    {
        // Validate and store the specialite data
        $data = $request->validated();

        // Assuming you have a Specialite model to handle the database interaction
        Specialite::create($data);

        return redirect()->route('specialites.index')->with('success', 'Spécialité ajoutée avec succès.');
    }
    public function index(Request $request)
    {
        // $query = Specialite::query();
        $query = Specialite::with('filiere'); // 👈 Charger les relations
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        $specialites = $query->paginate(9);
        return view('pages.specialites.list-specialite', compact('specialites'));
    }
    public function edit($id)
    {
        $specialite = Specialite::findOrFail($id);
        $filieres = Filiere::all(); // Récupérer les filières disponibles
        return view('pages.specialites.update-specialite', compact('specialite', 'filieres'));
    }
    public function update(SpecialiteRequest $request, $id)
    {
        $specialite = Specialite::findOrFail($id);
        $data = $request->validated();
        $specialite->update($data);
        return redirect()->route('specialites.index')->with('success', 'Spécialité mise à jour avec succès.');
    }
    public function delete($id)
    {
        $specialite = Specialite::findOrFail($id);
        $specialite->delete();
        return redirect()->route('specialites.index')->with('success', 'Spécialité supprimée avec succèss.');
    }
    public function show($id)
    {
        $specialite = Specialite::findOrFail($id);
        return view('pages.specialites.show-specialite', compact('specialite'));
    }
    public function getByFiliere($filiere_id)
    {
        $specialites = \App\Models\Specialite::where('filiere_id', $filiere_id)->get();

        return response()->json($specialites);
    }
    public function exportSpecialitePdf()
    {
        $specialites = Specialite::all();
        $pdf = PDF::loadview('pages.specialites.pdf', compact('specialites'));
        return $pdf->download('listes_specialites.pdf');
    }
}
