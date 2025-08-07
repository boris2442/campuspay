<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frai;
use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\Specialite;
use App\Models\User;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $niveaux = Niveau::all();
        $students = User::where('role', 'user')->get();
        $filieres = Filiere::all();
        $frais = Frai::first(); // Supposé être global
        $specialites = Specialite::all();

        // Labels et comptages par niveau
        $niveauLabels = $niveaux->pluck('name')->toArray();
        $niveauCounts = [];
        foreach ($niveaux as $niveau) {
            $niveauCounts[] = User::where('niveau_id', $niveau->id)->where('role', 'user')->count();
        }

        // Statut global des étudiants
        $statusPaiement = $this->getStatutGlobalEtudiants();

        // Montants par spécialité
        $montantsParSpecialite = $this->getMontantsParSpecialite();

        // Étudiants par filière
        $etudiantsParFiliere = $this->getEtudiantsParFiliere();
        $filieresLabels = $etudiantsParFiliere['labels'];
        $filieresCounts = $etudiantsParFiliere['counts'];

        // Évolution des paiements
        $evolutionPaiements = $this->getEvolutionPaiements();

        // Statistiques financières
        $statsFinancieres = $this->getStatistiquesFinancieres();

        // Pourcentage global de paiement
        $pourcentageTotal = $this->getPourcentageTotal();

        // Mode de paiement
        $paiementsParMode = Paiement::select('mode_paiement', DB::raw('COUNT(*) as total'))
            ->groupBy('mode_paiement')
            ->get();

        $studentsCount = $students->count();

        return view('pages.dashboard.dashboard2', compact(
            'niveauLabels',
            'niveauCounts',
            'filieres',
            'specialites',
            'students',
            'niveaux',
            'frais',
            'paiementsParMode',
            'statusPaiement',
            'montantsParSpecialite',
            'etudiantsParFiliere',
            'filieresLabels',
            'filieresCounts',
            'evolutionPaiements',
            'studentsCount',
            'statsFinancieres',
            'pourcentageTotal'
        ));
    }

    /**
     * Compte les étudiants par statut global : Complet / En cours
     */
    private function getStatutGlobalEtudiants()
    {
        $frais = Frai::first();
        if (!$frais) {
            return collect([
                ['statut' => 'Complet', 'total' => 0],
                ['statut' => 'En cours', 'total' => 0],
            ]);
        }

        $totalFrais = $frais->total;
        $etudiants = User::where('role', 'user')->with('paiements')->get();

        $stats = [
            'Complet' => 0,
            'En cours' => 0,
        ];

        foreach ($etudiants as $etudiant) {
            $totalPaye = $etudiant->paiements->sum('montant_paye');
            if ($totalPaye >= $totalFrais) {
                $stats['Complet']++;
            } else {
                $stats['En cours']++;
            }
        }

        return collect([
            ['statut' => 'Complet', 'total' => $stats['Complet']],
            ['statut' => 'En cours', 'total' => $stats['En cours']],
        ]);
    }

    /**
     * Montant total payé par spécialité
     */
    private function getMontantsParSpecialite()
    {
        return DB::table('paiements')
            ->join('users', 'paiements.user_id', '=', 'users.id')
            ->join('specialites', 'users.specialite_id', '=', 'specialites.id')
            ->where('users.role', 'user')
            ->select('specialites.name', DB::raw('SUM(paiements.montant_paye) as total'))
            ->groupBy('specialites.name')
            ->get();
    }

    /**
     * Nombre d'étudiants par filière
     */
    private function getEtudiantsParFiliere()
    {
        $filieres = Filiere::all();
        $labels = $filieres->pluck('name')->toArray();
        $counts = [];

        foreach ($filieres as $filiere) {
            $counts[] = User::where('filiere_id', $filiere->id)->where('role', 'user')->count();
        }

        return compact('labels', 'counts');
    }

    /**
     * Évolution des paiements par jour
     */
    private function getEvolutionPaiements()
    {
        return Paiement::selectRaw('DATE(created_at) as date, SUM(montant_paye) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
    }

    /**
     * Statistiques financières globales
     */
    private function getStatistiquesFinancieres()
    {
        $frais = Frai::first();
        $nombreEtudiants = User::where('role', 'user')->count();

        if (!$frais) {
            return [
                'totalAttendu' => 0,
                'totalVerse' => 0,
                'resteAVerser' => 0,
            ];
        }

        $totalAttendu = $frais->total * $nombreEtudiants;
        $totalVerse = Paiement::sum('montant_paye');
        $resteAVerser = max(0, $totalAttendu - $totalVerse);

        return compact('totalAttendu', 'totalVerse', 'resteAVerser');
    }

    /**
     * Pourcentage global de paiement
     */
    private function getPourcentageTotal()
    {
        $frais = Frai::first();
        if (!$frais) return 0;

        $nombreEtudiants = User::where('role', 'user')->count();
        $totalAttendu = $frais->total * $nombreEtudiants;
        $totalVerse = Paiement::sum('montant_paye');

        return $totalAttendu > 0 ? round(($totalVerse / $totalAttendu) * 100, 1) : 0;
    }
}