<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NiveauRequest;
use App\Models\Niveau;
use App\Models\Specialite;

class NiveauController extends Controller
{
    //

    public function index()
    {
        $niveaux = Niveau::paginate(5);
        return view('pages.niveaux.list-niveau', compact('niveaux'));
    }
    public function create()
    {
        $specialites = Specialite::all();
        return view('pages.niveaux.add-niveau', compact('specialites'));
    }
    public function store(NiveauRequest $request)
    {
        // Si tu as un NiveauRequest, remplace Request par NiveauRequest
        $data = $request->validated();
        Niveau::create($data);
        return redirect()->route('niveaux.index')->with('success', 'Niveau ajouté avec succès.');
    }

    public function edit($id)
    {
        $specialites = Specialite::all();
        $niveau = Niveau::findOrFail($id);
        return view('pages.niveaux.update-niveau', compact('niveau', 'specialites'));
    }

    public function update(NiveauRequest $request, $id)
    {
        // Si tu as un NiveauRequest, remplace Request par NiveauRequest
        $data = $request->validated();
        $niveau = Niveau::findOrFail($id);
        $niveau->update($data);
        return redirect()->route('niveaux.index')->with('success', 'Niveau modifié avec succès.');
    }

    public function delete($id)
    {
        $niveau = Niveau::findOrFail($id);
        $niveau->delete();
        return redirect()->route('niveaux.index')->with('success', 'Niveau supprimé avec succès.');
    }
}
