<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaiementRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialite;
use App\Models\Paiement;
use App\Models\Frai;
use App\Exports\PaiementsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// class PaiementController extends Controller
// {


//     public function index(Request $request)
//     {

//         $query = Paiement::with('user.specialite');


//         $query->whereHas('user', function ($q) {
//             $q->where('role', 'user');
//         });




//         if ($request->filled('date_debut') && $request->filled('date_fin')) {
//             $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
//         }


//         if ($request->filled('specialite_id')) {
//             $query->whereHas('user.specialite', function ($q) use ($request) {
//                 $q->where('id', $request->specialite_id);
//             });
//         }


//         if ($request->filled('nom_etudiant')) {
//             $query->whereHas('user', function ($q) use ($request) {
//                 $q->where('name', 'like', '%' . $request->nom_etudiant . '%');
//             });
//         }


//         if ($request->filled('statut')) {
//             $query->where('statut', $request->statut);
//         }


//         if ($request->filled('tranche_paye')) {
//             $query->where('tranche_paye', $request->tranche_paye);
//         }


//         $paiements = $query->orderBy('created_at', 'desc')->get();


//         $totalMontant = $paiements->sum('montant_paye');


//         $nombreEtudiantsPayeurs = $paiements->pluck('user_id')->unique()->count();


//         $specialites = Specialite::orderBy('name')->get();


//         return view('pages.paiements.index-all', compact('paiements', 'totalMontant', 'nombreEtudiantsPayeurs', 'specialites'));
//     }

//     public function create()
//     {

//         $students = User::where('role', 'user')->get();

//         $frais = Frai::first();

//         return view('pages.paiements.add-paiement', compact('students', 'frais'));
//     }

//     public function store(PaiementRequest $request)
//     {
//         $request->validated();


//         $dejaPaye = Paiement::where('user_id', $request->user_id)
//             ->where('tranche_paye', $request->tranche_paye)
//             ->exists();

//         if ($dejaPaye) {
//             return back()->withErrors([
//                 'tranche_paye' => 'Cet étudiant a déjà payé cette tranche.',
//             ])->withInput();
//         }


//         $ordreTranches = ['tranche1', 'tranche2', 'tranche3'];
//         $index = array_search($request->tranche_paye, $ordreTranches);

//         for ($i = 0; $i < $index; $i++) {
//             $trancheAvant = $ordreTranches[$i];
//             $aDejaPaye = Paiement::where('user_id', $request->user_id)
//                 ->where('tranche_paye', $trancheAvant)
//                 ->exists();

//             if (! $aDejaPaye) {
//                 return back()->withErrors([
//                     'tranche_paye' => "Vous devez d'abord payer la tranche " . ucfirst($trancheAvant) . ".",
//                 ])->withInput();
//             }
//         }


//         $frais = Frai::first();
//         $montantPaye = $frais->{$request->tranche_paye};


//         Paiement::create([
//             'user_id' => $request->user_id,
//             'frais_id' => $frais->id,
//             'tranche_paye' => $request->tranche_paye,
//             'montant_paye' => $montantPaye,
//             'mode_paiement' => $request->mode_paiement,
//             'statut' => 'en_attente',
//         ]);

//         return back()->with('success', 'Paiement enregistré avec succès !');
//     }

//     public function edit(Paiement $paiement)
//     {

//         $students = User::where('role', 'user')->get();

//         $frais = Frai::with('user')->first();
//         if (!$frais) {
//             return redirect()->back()->withErrors(['general' => 'Aucun frais trouvé dans la base de données.']);
//         }
//         return view('pages.paiements.update-paiement', compact('paiement', 'students', 'frais'));
//     }

//     public function update(PaiementRequest $request, Paiement $paiement)
//     {
//         $data = $request->validated();

//         $frais = Frai::findOrFail($request->frais_id);

//         $trancheField = 'tranche' . $request->tranche_paye;
//         if ($request->montant_paye > $frais->$trancheField) {
//             return back()->withErrors([
//                 'montant_paye' => 'Le montant payé dépasse le montant de la ' . ucfirst($trancheField) . ' (' . $frais->$trancheField . ' FCFA).',
//             ])->withInput();
//         }

//         $totalPaye = Paiement::where('frais_id', $frais->id)
//             ->where('user_id', $request->user_id)
//             ->where('id', '!=', $paiement->id) 
//             ->sum('montant_paye');

//         if (($totalPaye + $request->montant_paye) > $frais->total) {
//             return back()->withErrors([
//                 'montant_paye' => 'Le montant dépasse le total des frais (' . $frais->total . ' FCFA).',
//             ])->withInput();
//         }

//         try {
//             $paiement->update($data);
//             return redirect()->route('paiements.create')->with('success', 'Paiement mis à jour avec succès !');
//         } catch (\Exception $e) {

//             return back()->withErrors(['general' => 'Une erreur est survenue lors de la mise à jour du paiement.'])->withInput();
//         }
//     }

//     public function destroy(Paiement $paiement)
//     {
//         try {
//             $paiement->delete();
//             return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès !');
//         } catch (\Exception $e) {

//             return back()->withErrors(['general' => 'Une erreur est survenue lors de la suppression du paiement.']);
//         }
//     }

//     public function indexPaymentsForUser($userId)
//     {



//         $user = User::findOrFail($userId);
//         if ($user->role !== 'user') {
//             abort(403, 'Accès interdit. Ce n’est pas un étudiant.');
//         }
//         $paiements = Paiement::where('user_id', $userId)->get(); 
//         $frais = Frai::first(); 
//         $totalPaye = $paiements->sum('montant_paye');

//         $totalFrais = $frais->total ?? 0;
//         $fraisRestant = $totalFrais -  $totalPaye;
//         $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

//         return view('pages.paiements.indexForUser', compact('paiements', 'totalPaye', 'totalFrais', 'statutGlobal', 'user', 'fraisRestant'));
//     }
//     public function export()
//     {
//         return Excel::download(new PaiementsExport, 'paiements.xlsx');
//     }
//     public function exportPdf()
//     {
//         $paiements = Paiement::all();  
//         $pdf = PDF::loadView('pages.paiements.pdf-user', compact('paiements'));
//         return $pdf->download('liste_paiements.pdf');
//     }




//     public function showUserPayments()
//     {
//         $user = auth()->user();


//         if ($user->role !== 'user') {
//             abort(403, 'Accès réservé aux étudiants.');
//         }

//         $paiements = Paiement::where('user_id', $user->id)->get();
//         $frais = Frai::first();
//         $totalPaye = $paiements->sum('montant_paye');
//         $totalFrais = $frais->total ?? 0;
//         $fraisRestant = $totalFrais - $totalPaye;
//         $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

//         return view('pages.paiements.paiementForUser', compact(
//             'paiements',
//             'totalPaye',
//             'totalFrais',
//             'statutGlobal',
//             'user',
//             'fraisRestant'
//         ));
//     }


//     public function exportUserPdf()
//     {
//         $user = auth()->user();


//          if ($user->role !== 'user') {
//              abort(403, 'Accès réservé aux étudiants.');
//          }

//         $paiements = Paiement::where('user_id', $user->id)->get();


//         $frais = Frai::first();
//         $totalPaye = $paiements->sum('montant_paye');
//         $totalFrais = $frais->total ?? 0;
//         $fraisRestant = $totalFrais - $totalPaye;
//         $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

//         $pdf = PDF::loadView('pages.paiements.pdf-user', compact(
//             'user',
//             'paiements',
//             'totalPaye',
//             'totalFrais',
//             'fraisRestant',
//             'statutGlobal'
//         ));

//         return $pdf->download("reçu-paiement-{$user->name}.pdf");
//     }
// }
class PaiementController extends Controller
{
    /**
     * Liste tous les paiements avec filtres.
     */
    public function index(Request $request)
    {
        $query = Paiement::with('user.specialite');
        $query->whereHas('user', function ($q) {
            $q->where('role', 'user');
        });

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('specialite_id')) {
            $query->whereHas('user.specialite', function ($q) use ($request) {
                $q->where('id', $request->specialite_id);
            });
        }

        if ($request->filled('nom_etudiant')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nom_etudiant . '%');
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $paiements = $query->orderBy('created_at', 'desc')->get();
        $totalMontant = $paiements->sum('montant_paye');
        $nombreEtudiantsPayeurs = $paiements->pluck('user_id')->unique()->count();
        $specialites = Specialite::orderBy('name')->get();

        return view('pages.paiements.index-all', compact('paiements', 'totalMontant', 'nombreEtudiantsPayeurs', 'specialites'));
    }

    /**
     * Affiche le formulaire d'ajout de paiement.
     */
    public function create()
    {
        $students = User::where('role', 'user')->get();
        $frais = Frai::first();

        if (!$frais) {
            return redirect()->back()->withErrors(['general' => 'Les frais ne sont pas configurés.']);
        }

        return view('pages.paiements.add-paiement', compact('students', 'frais'));
    }

    /**
     * Enregistre un paiement (montant libre, pas de blocage par tranche).
     */
    public function store(PaiementRequest $request)
    {
        $request->validated();

        $frais = Frai::first();
        if (!$frais) {
            return back()->withErrors(['general' => 'Les frais ne sont pas configurés.'])->withInput();
        }

        $userId = $request->user_id;
        $montantPaye = $request->montant_paye;

        // Calculer le total déjà payé
        $totalPayeActuel = Paiement::where('user_id', $userId)->sum('montant_paye');
        $nouveauTotal = $totalPayeActuel + $montantPaye;

        // Vérifier que le total ne dépasse pas le montant dû
        if ($nouveauTotal > $frais->total) {
            return back()->withErrors([
                'montant_paye' => "Le montant total payé ({$nouveauTotal} FCFA) dépasse le montant des frais ({$frais->total} FCFA)."
            ])->withInput();
        }

        // Enregistrer le paiement
        Paiement::create([
            'user_id' => $userId,
            'frais_id' => $frais->id,
            'montant_paye' => $montantPaye,
            'mode_paiement' => $request->mode_paiement,
            'statut' => $nouveauTotal >= $frais->total ? 'complet' : 'en_cours',
            'tranche_paye' => 'partiel', // ou null, ou 'trancheX' selon logique
        ]);

        return back()->with('success', 'Paiement enregistré avec succès !');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Paiement $paiement)
    {
        $students = User::where('role', 'user')->get();
        $frais = Frai::first();

        if (!$frais) {
            return redirect()->back()->withErrors(['general' => 'Aucun frais trouvé.']);
        }

        return view('pages.paiements.update-paiement', compact('paiement', 'students', 'frais'));
    }

    /**
     * Met à jour un paiement.
     */
    public function update(PaiementRequest $request, Paiement $paiement)
    {
        $request->validated();
        $frais = Frai::findOrFail($request->frais_id);

        $montantPaye = $request->montant_paye;
        $totalPayeSansActuel = Paiement::where('user_id', $request->user_id)
            ->where('id', '!=', $paiement->id)
            ->sum('montant_paye');

        if ($totalPayeSansActuel + $montantPaye > $frais->total) {
            return back()->withErrors([
                'montant_paye' => "Le montant total dépasserait le plafond de {$frais->total} FCFA."
            ])->withInput();
        }

        $paiement->update([
            'user_id' => $request->user_id,
            'frais_id' => $frais->id,
            'montant_paye' => $montantPaye,
            'mode_paiement' => $request->mode_paiement,
            'statut' => ($totalPayeSansActuel + $montantPaye) >= $frais->total ? 'complet' : 'en_cours',
        ]);

        return redirect()->route('paiements.create')->with('success', 'Paiement mis à jour avec succès !');
    }

    /**
     * Supprime un paiement.
     */
    public function destroy(Paiement $paiement)
    {
        try {
            $paiement->delete();
            return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès !');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Erreur lors de la suppression.']);
        }
    }

    /**
     * Affiche les paiements d’un étudiant.
     */
    public function indexPaymentsForUser($userId)
    {
        $user = User::findOrFail($userId);
        if ($user->role !== 'user') {
            abort(403, 'Accès interdit.');
        }

        $paiements = Paiement::where('user_id', $userId)->get();
        $frais = Frai::first();
        $totalPaye = $paiements->sum('montant_paye');
        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais - $totalPaye;
        $statutGlobal = $totalPaye >= $totalFrais ? 'Complet' : 'En cours';

        return view('pages.paiements.indexForUser', compact('paiements', 'totalPaye', 'totalFrais', 'fraisRestant', 'statutGlobal', 'user'));
    }

    /**
     * Export Excel.
     */
    public function export()
    {
        return Excel::download(new PaiementsExport, 'paiements.xlsx');
    }

    /**
     * Export PDF.
     */
    // public function exportPdf()
    // {

    //     $paiements = Paiement::with('user')->get();
    //     $pdf = PDF::loadView('pages.paiements.pdf-user', compact('paiements'));
    //     return $pdf->download('liste_paiements.pdf');
    // }
    public function exportPdf()
    {
        $date = Carbon::now()->format('d-m-Y_H\hi');
        $paiements = Paiement::with('user')->get();
        // $pdf = PDF::loadView('pages.paiements.pdf-user', compact('paiements'));
        $pdf = PDF::loadView('pages.paiements.pdf', compact('paiements'));

        return $pdf->download('liste_paiements_au_' . $date . '.pdf');
    }
    /**
     * Affiche les paiements pour l’étudiant connecté.
     */
    public function showUserPayments()
    {
        $user = auth()->user();
        if ($user->role !== 'user') {
            abort(403, 'Accès réservé aux étudiants.');
        }

        $paiements = Paiement::where('user_id', $user->id)->get();
        $frais = Frai::first();
        $totalPaye = $paiements->sum('montant_paye');
        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais - $totalPaye;
        $statutGlobal = $totalPaye >= $totalFrais ? 'Complet' : 'En cours';

        return view('pages.paiements.paiementForUser', compact('paiements', 'totalPaye', 'totalFrais', 'fraisRestant', 'statutGlobal', 'user'));
    }

    /**
     * Export PDF pour l’étudiant connecté.
     */
    public function exportUserPdf()
    {
        $date = Carbon::now()->format('d-m-Y_H\hi');
        $user = auth()->user();
        if ($user->role !== 'user') {
            abort(403, 'Accès réservé aux étudiants.');
        }

        $paiements = Paiement::where('user_id', $user->id)->get();
        $frais = Frai::first();
        $totalPaye = $paiements->sum('montant_paye');
        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais - $totalPaye;
        $statutGlobal = $totalPaye >= $totalFrais ? 'Complet' : 'En cours';

        $pdf = PDF::loadView('pages.paiements.pdf-user', compact('user', 'paiements', 'totalPaye', 'totalFrais', 'fraisRestant', 'statutGlobal'));
        // return $pdf->download("reçu-paiement-de-{$user->name}-au.$date.pdf");
        $filename = "recu_paiement_de_{$user->name}_au_{$date}.pdf";

        return $pdf->download($filename);
    }
}
