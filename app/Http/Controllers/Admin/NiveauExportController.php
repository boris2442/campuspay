<?php

namespace App\Http\Controllers\Admin;

use App\Models\Niveau;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class NiveauExportController extends Controller
{
    public function exportPdf()
    {
        $niveaux = Niveau::all();

        $pdf = Pdf::loadView('pages.niveaux.pdf', compact('niveaux'))
                 ->setPaper('A4', 'portrait');

        return $pdf->download('liste_niveaux.pdf');
    }
}
