<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filiere;
//use Barryvdh\DomPDF\PDF;
// use Illuminate\Http\Request;
use PDF;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiliereRequest;

class FiliereController extends Controller
{
    //
    public function index()
    {
        $filieres = Filiere::paginate(6);
        return view('pages.filieres.list-filiere', compact('filieres'));
    }
    public function create()
    {
        return view('pages.filieres.add-filiere');
    }
    public function store(FiliereRequest $request)
    {
        $validateData = $request->validated();
        Filiere::create($validateData);
        return redirect()->route('filieres.index')->with('success', 'filiere ajoutée avec success');
    }
    public function delete($id)
    {
        $filiere = Filiere::findOrFail($id);
        $filiere->delete();

        return redirect()->route('filieres.index')->with('success', 'filiere supprimé avec succès.');
    }

    public function edit($id)
    {
        $filiere = Filiere::findOrFail($id);
        return view('pages.filieres.update-filiere', compact('filiere'));
    }

    public function update(FiliereRequest $request, $id)
    {
        // Si tu as un NiveauRequest, remplace Request par NiveauRequest
        $data = $request->validated();
        $filiere = Filiere::findOrFail($id);
        $filiere->update($data);
        return redirect()->route('filieres.index')->with('success', 'Filiere modifié avec succès.');
    }
    public function show($id)
    {
        $filiere = Filiere::findOrFail($id);
        return view('pages.filieres.show-filiere', compact('filiere'));
    }

    public function exportPdf()
    {
        $filieres = Filiere::all();
        $pdf = PDF::loadView('pages.filieres.pdf', compact('filieres'));
        return $pdf->download('liste_filieres.pdf');
    }
}
