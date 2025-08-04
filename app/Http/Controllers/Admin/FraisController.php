<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FraisRequest;
use PDF;
use App\Models\Frai;

class FraisController extends Controller
{
    //
    public function index()
    {
        $frais = Frai::paginate(5);
        return view('pages.frais.list-frais', compact('frais'));
    }
    public function create()
    {
        return view('pages.frais.add-frais');
    }
    public function store(FraisRequest $request)
    {
        $data = $request->validated();
        $data['total'] = $data['tranche1'] + $data['tranche2'] + $data['tranche3'];
        Frai::create($data);
        return redirect()->route('frais.index')->with('Frais add with successfull');
    }

    public function delete($id)
    {
        $frais = Frai::findOrFail($id);
        $frais->delete();

        return redirect()->route('frais.index')->with('success', 'Frais supprimé avec succès.');
    }
    public function edit($id)
    {
        $frais = Frai::findOrFail($id);
        return view('pages.frais.update-frais', compact('frais'));
    }

    public function update(FraisRequest $request, $id)
    {
        $frais = Frai::findOrFail($id);
        $data = $request->validated();
        $data['total'] = $data['tranche1'] + $data['tranche2'] + $data['tranche3'];
        $frais->update($data);

        return redirect()->route('frais.index')->with('success', 'Frais modifié avec succès.');
    }

    public function exportPdfFrais()
    {
        $frais = Frai::all();  // Récupère toutes les données de frais
        $pdf = PDF::loadView('pages.frais.pdf', compact('frais'));
        return $pdf->download('liste_fraiss.pdf');
    }
}
