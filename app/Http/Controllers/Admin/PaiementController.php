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
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    //
    // public function index()
    // {

    //     $paiements = Paiement::with('user')->orderBy('created_at', 'desc')->get();
    //      $nombreEtudiantsPayeurs = Paiement::distinct('user_id')->count('user_id');
    //     $totalMontant = $paiements->sum('montant_paye');
    //     return view('pages.paiements.index-all', compact('paiements', 'totalMontant','nombreEtudiantsPayeurs'));
    // }


    public function index(Request $request)
    {
        // On commence la requête sur les paiements avec relations user et spécialité
        $query = Paiement::with('user.specialite');


        $query->whereHas('user', function ($q) {
            $q->where('role', 'user');
        });



        // Filtrer par période
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
        }

        // Filtrer par spécialité
        if ($request->filled('specialite_id')) {
            $query->whereHas('user.specialite', function ($q) use ($request) {
                $q->where('id', $request->specialite_id);
            });
        }

        // Filtrer par nom étudiant (recherche partielle)
        if ($request->filled('nom_etudiant')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nom_etudiant . '%');
            });
        }

        // Filtrer par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrer par tranche payée
        if ($request->filled('tranche_paye')) {
            $query->where('tranche_paye', $request->tranche_paye);
        }

        // On récupère les paiements filtrés (paginate si tu veux, sinon get())
        $paiements = $query->orderBy('created_at', 'desc')->get();

        // Calcul du total des montants
        $totalMontant = $paiements->sum('montant_paye');

        // Calcul du nombre d'étudiants distincts ayant effectué au moins un paiement
        $nombreEtudiantsPayeurs = $paiements->pluck('user_id')->unique()->count();

        // Récupérer toutes les spécialités pour le select
        $specialites = Specialite::orderBy('name')->get();

        // Retourner la vue avec toutes les données
        return view('pages.paiements.index-all', compact('paiements', 'totalMontant', 'nombreEtudiantsPayeurs', 'specialites'));
    }

    public function create()
    {
        // $students = User::all();
        $students = User::where('role', 'user')->get();

        $frais = Frai::first(); // frais global unique

        return view('pages.paiements.add-paiement', compact('students', 'frais'));
    }

    public function store(PaiementRequest $request)
    {
        $request->validated();

        // 1. Vérifier que la tranche n’a pas déjà été payée par cet étudiant
        $dejaPaye = Paiement::where('user_id', $request->user_id)
            ->where('tranche_paye', $request->tranche_paye)
            ->exists();

        if ($dejaPaye) {
            return back()->withErrors([
                'tranche_paye' => 'Cet étudiant a déjà payé cette tranche.',
            ])->withInput();
        }

        // 2. Vérifier que les tranches précédentes sont payées (pas de saut de tranche)
        $ordreTranches = ['tranche1', 'tranche2', 'tranche3'];
        $index = array_search($request->tranche_paye, $ordreTranches);

        for ($i = 0; $i < $index; $i++) {
            $trancheAvant = $ordreTranches[$i];
            $aDejaPaye = Paiement::where('user_id', $request->user_id)
                ->where('tranche_paye', $trancheAvant)
                ->exists();

            if (! $aDejaPaye) {
                return back()->withErrors([
                    'tranche_paye' => "Vous devez d'abord payer la tranche " . ucfirst($trancheAvant) . ".",
                ])->withInput();
            }
        }

        // 3. Récupérer le montant de la tranche choisie
        $frais = Frai::first();
        $montantPaye = $frais->{$request->tranche_paye};

        // 4. Enregistrer le paiement avec montant automatique
        Paiement::create([
            'user_id' => $request->user_id,
            'frais_id' => $frais->id,
            'tranche_paye' => $request->tranche_paye,
            'montant_paye' => $montantPaye,
            'mode_paiement' => $request->mode_paiement,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Paiement enregistré avec succès !');
    }

    public function edit(Paiement $paiement)
    {
        // $students = User::all();
        $students = User::where('role', 'user')->get();

        $frais = Frai::with('user')->first();
        if (!$frais) {
            return redirect()->back()->withErrors(['general' => 'Aucun frais trouvé dans la base de données.']);
        }
        return view('pages.paiements.update-paiement', compact('paiement', 'students', 'frais'));
    }

    public function update(PaiementRequest $request, Paiement $paiement)
    {
        $data = $request->validated();

        $frais = Frai::findOrFail($request->frais_id);

        $trancheField = 'tranche' . $request->tranche_paye;
        if ($request->montant_paye > $frais->$trancheField) {
            return back()->withErrors([
                'montant_paye' => 'Le montant payé dépasse le montant de la ' . ucfirst($trancheField) . ' (' . $frais->$trancheField . ' FCFA).',
            ])->withInput();
        }

        $totalPaye = Paiement::where('frais_id', $frais->id)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $paiement->id) // Exclure le paiement actuel
            ->sum('montant_paye');

        if (($totalPaye + $request->montant_paye) > $frais->total) {
            return back()->withErrors([
                'montant_paye' => 'Le montant dépasse le total des frais (' . $frais->total . ' FCFA).',
            ])->withInput();
        }

        try {
            $paiement->update($data);
            return redirect()->route('paiements.create')->with('success', 'Paiement mis à jour avec succès !');
        } catch (\Exception $e) {
            // \Log::error('Erreur lors de la mise à jourArtigo du paiement : ' . $e->getMessage());
            return back()->withErrors(['general' => 'Une erreur est survenue lors de la mise à jour du paiement.'])->withInput();
        }
    }

    public function destroy(Paiement $paiement)
    {
        try {
            $paiement->delete();
            return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès !');
        } catch (\Exception $e) {

            return back()->withErrors(['general' => 'Une erreur est survenue lors de la suppression du paiement.']);
        }
    }

    public function indexPaymentsForUser($userId)
    {



        $user = User::findOrFail($userId);
        if ($user->role !== 'user') {
            abort(403, 'Accès interdit. Ce n’est pas un étudiant.');
        }
        $paiements = Paiement::where('user_id', $userId)->get(); //récupère tous les paiements effectués par cet utilisateur.
        // dd($paiements);
        $frais = Frai::first(); // recuperer la premiere ligne des paiements
        //dans la mesure ou tous les etudiants n'ont pas les memes frais,,,,,,,,,,,,,
        //$frais = Frai::where('user_id', $userId)->first()).
        // $totalPaye = $paiements->where('statut', 'valide')->sum('montant_paye');
        $totalPaye = $paiements->sum('montant_paye');

        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais -  $totalPaye;
        $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

        return view('pages.paiements.indexForUser', compact('paiements', 'totalPaye', 'totalFrais', 'statutGlobal', 'user', 'fraisRestant'));
    }
    public function export()
    {
        return Excel::download(new PaiementsExport, 'paiements.xlsx');
    }
    public function exportPdf()
    {
        $paiements = Paiement::all();  // Récupère toutes les données de paiements
        $pdf = PDF::loadView('pages.paiements.pdf-user', compact('paiements'));
        return $pdf->download('liste_paiements.pdf');
    }




    public function showUserPayments()
    {
        $user = auth()->user();

        // Assure que c'est bien un étudiant
        if ($user->role !== 'user') {
            abort(403, 'Accès réservé aux étudiants.');
        }

        $paiements = Paiement::where('user_id', $user->id)->get();
        $frais = Frai::first(); // tu peux adapter si les frais sont par filière/spécialité
        $totalPaye = $paiements->sum('montant_paye');
        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais - $totalPaye;
        $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

        return view('pages.paiements.paiementForUser', compact(
            'paiements',
            'totalPaye',
            'totalFrais',
            'statutGlobal',
            'user',
            'fraisRestant'
        ));
    }

    // public function exportUserPdf()
    // {
    //     $user = Auth::user();
    //     $paiements = $user->paiements()->latest()->get();
    //     $totalPaye = $paiements->sum('montant_paye');
    //     $totalFrais = $user->filiere && $user->filiere->frais
    //         ? $user->filiere->frais->sum('montant')
    //         : 0;

    //     $fraisRestant = $totalFrais - $totalPaye;
    //     $statutGlobal = $fraisRestant <= 0 ? 'Complet' : 'Incomplet';

    //     $pdf = PDF::loadView('pages.paiements.pdf-user', compact(
    //         'user',
    //         'paiements',
    //         'totalPaye',
    //         'totalFrais',
    //         'fraisRestant',
    //         'statutGlobal'
    //     ));

    //     return $pdf->download("reçu-paiement-{$user->name}.pdf");
    // }

    public function exportUserPdf()
    {
        $user = auth()->user();

        // Assure que c'est bien un étudiant
         if ($user->role !== 'user') {
             abort(403, 'Accès réservé aux étudiants.');
         }

        $paiements = Paiement::where('user_id', $user->id)->get();

        // Récupère le frais global (ou adapte selon ta logique future)
        $frais = Frai::first();
        $totalPaye = $paiements->sum('montant_paye');
        $totalFrais = $frais->total ?? 0;
        $fraisRestant = $totalFrais - $totalPaye;
        $statutGlobal = ($totalPaye >= $totalFrais) ? 'Complet' : 'En attente';

        $pdf = PDF::loadView('pages.paiements.pdf-user', compact(
            'user',
            'paiements',
            'totalPaye',
            'totalFrais',
            'fraisRestant',
            'statutGlobal'
        ));

        return $pdf->download("reçu-paiement-{$user->name}.pdf");
    }
}
