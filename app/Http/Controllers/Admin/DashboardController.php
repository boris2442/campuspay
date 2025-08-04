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

// class DashboardController extends Controller
// {
  
//     public function dashboard()
//     {
//         $paiementsParMode = Paiement::select('mode_paiement', DB::raw('COUNT(*) as total'))
//             ->groupBy('mode_paiement')
//             ->get();


//         $niveaux = Niveau::all();

//         $students = User::where('role', 'user')->get();
//         $filieres = Filiere::all();
//         $frais = Frai::all();
      
//         $niveauLabels = $niveaux->pluck('name')->toArray();
//         $specialites = Specialite::all();
       
//         $niveauCounts = [];
//         foreach ($niveaux as $niveau) {
//             $niveauCounts[] = User::where('niveau_id', $niveau->id)->where('role', 'user')->count();
//         }

//         $statusPaiement = $this->getPaiementsParStatut();
 


//         $montantsParSpecialite = $this->getMontantsParSpecialite();
//         $etudiantsParFiliere = $this->getEtudiantsParFiliere();
//         $evolutionPaiements = $this->getEvolutionPaiements();
//         $statsFinancieres = $this->getStatistiquesFinancieres();

//         $filieresLabels = $etudiantsParFiliere['labels'];
//         $filieresCounts = $etudiantsParFiliere['counts'];
//         $montantsParTranche = $this->getMontantsParTranche();
    
//         $studentsCount = User::where('role', 'user')->count();

//         $pourcentagesParTranche = $this->getPourcentagesParTranche();
//         $pourcentageTotal = $this->getPourcentageTotal();

//         $montantsRestantsParTranche = $this->getMontantsRestantsParTranche($studentsCount);
//         return view('pages.dashboard.dashboard2', compact(
//             'niveauLabels',
//             'niveauCounts',
//             'filieres',
//             'specialites',
//             'students',
//             'niveaux',
//             'frais',
//             'paiementsParMode',
//             'statusPaiement',
//             'montantsParSpecialite',
//             'etudiantsParFiliere',
//             'filieresLabels',
//             'filieresCounts',
//             'evolutionPaiements',
//             'montantsParTranche',
//             'montantsRestantsParTranche',
//             'studentsCount',
//             'statsFinancieres',
//             'pourcentagesParTranche',
//             'pourcentageTotal',



//         ));
//     }

  
//     private function getPaiementsParStatut()
//     {
//         $frais = \App\Models\Frai::first();

//         if (!$frais) {
//             return collect([
//                 ['statut' => 'valide', 'total' => 0],
//                 ['statut' => 'en_attente', 'total' => 0],
//                 ['statut' => 'rejete', 'total' => 0],
//             ]);
//         }

//         $montantTotalAttendu = $frais->tranche1 + $frais->tranche2 + $frais->tranche3;

//         $statuts = [
//             'valide' => 0,
//             'en_attente' => 0,
//             'rejete' => 0,
//         ];

      
//         $etudiants = User::where('role', 'user')->with('paiements')->get();

//         foreach ($etudiants as $etudiant) {
//             $paiements = $etudiant->paiements;

           
//             if ($paiements->isEmpty()) {
//                 $statuts['en_attente']++;
//                 continue;
//             }

           
//             if ($paiements->contains('statut', 'rejete')) {
//                 $statuts['rejete']++;
//                 continue;
//             }

    
//             $totalPaye = $paiements->filter(fn($p) => strtolower($p->statut) === 'valide')->sum('montant_paye');


//             if ($totalPaye >= $montantTotalAttendu) {
//                 $statuts['valide']++;
//             } else {
//                 $statuts['en_attente']++;
//             }
//         }

//         return collect([
//             ['statut' => 'valide', 'total' => $statuts['valide']],
//             ['statut' => 'en_attente', 'total' => $statuts['en_attente']],
//             ['statut' => 'rejete', 'total' => $statuts['rejete']],
//         ]);
//     }




//     private function getMontantsParSpecialite()
//     {

//         return DB::table('paiements')
//             ->join('users', 'paiements.user_id', '=', 'users.id')
//             ->join('specialites', 'users.specialite_id', '=', 'specialites.id')
//             ->where('users.role', 'user') 
//             ->select('specialites.name', DB::raw('SUM(montant_paye) as total'))
//             ->groupBy('specialites.name')
//             ->get();
//     }
//     private function getEtudiantsParFiliere()
//     {
//         $filieres = Filiere::all();
//         $filieresLabels = $filieres->pluck('name')->toArray();

//         $filieresCounts = [];
//         foreach ($filieres as $filiere) {
//             $filieresCounts[] = User::where('filiere_id', $filiere->id)->where('role', 'user')->count();
//         }

//         return [
//             'labels' => $filieresLabels,
//             'counts' => $filieresCounts,
//         ];
//     }

//     private function getEvolutionPaiements()
//     {
//         return Paiement::selectRaw('DATE(created_at) as date, SUM(montant_paye) as total')
//             ->groupBy('date')
//             ->orderBy('date', 'ASC')
//             ->get();
//     }
//     private function getMontantsParTranche()
//     {
//         $tranches = ['tranche1', 'tranche2', 'tranche3'];
//         $montants = [];

//         foreach ($tranches as $tranche) {
//             $montants[$tranche] = Paiement::where('tranche_paye', $tranche)->sum('montant_paye');
//         }

//         return $montants;
//     }
//     private function getMontantsRestantsParTranche(int $studentsCount)
//     {
   
//         $frais = Frai::first();

//         if (!$frais) {
          
//             return [
//                 'tranche1' => 0,
//                 'tranche2' => 0,
//                 'tranche3' => 0,
//             ];
//         }

     
//         $totalAttenduTranche1 = $studentsCount * $frais->tranche1;
//         $totalAttenduTranche2 = $studentsCount * $frais->tranche2;
//         $totalAttenduTranche3 = $studentsCount * $frais->tranche3;

   
//         $payesTranche1 = Paiement::where('tranche_paye', 'tranche1')->sum('montant_paye');
//         $payesTranche2 = Paiement::where('tranche_paye', 'tranche2')->sum('montant_paye');
//         $payesTranche3 = Paiement::where('tranche_paye', 'tranche3')->sum('montant_paye');

  
//         $resteTranche1 = max(0, $totalAttenduTranche1 - $payesTranche1);
//         $resteTranche2 = max(0, $totalAttenduTranche2 - $payesTranche2);
//         $resteTranche3 = max(0, $totalAttenduTranche3 - $payesTranche3);

//         return [
//             'tranche1' => $resteTranche1,
//             'tranche2' => $resteTranche2,
//             'tranche3' => $resteTranche3,
//         ];
//     }


  
//     private function getStatistiquesFinancieres()
//     {
//         $frais = Frai::first();
//         $nombreEtudiants = User::where('role', 'user')->count();

//         $totalAttendu = $frais ? $frais->total * $nombreEtudiants : 0;


//         $totalVerse = Paiement::sum('montant_paye');
//         $resteAVerser = $totalAttendu - $totalVerse;

//         return compact('totalAttendu', 'totalVerse', 'resteAVerser');
//     }

//     private function getPourcentagesParTranche()
//     {
//         $frais = Frai::first(); 
//         $nombreEtudiants = User::where('role', 'user')->count();
//         $tranches = ['tranche1', 'tranche2', 'tranche3'];
//         $pourcentages = [];

      
//         if (!$frais) {
//             foreach ($tranches as $tranche) {
//                 $pourcentages[$tranche] = 0;
//             }
//             return $pourcentages;
//         }

//         foreach ($tranches as $tranche) {
//             $montantAttendu = $frais->$tranche * $nombreEtudiants;
//             $montantPaye = Paiement::where('tranche_paye', $tranche)->sum('montant_paye');
//             $pourcentages[$tranche] = $montantAttendu > 0
//                 ? round(($montantPaye / $montantAttendu) * 100, 1)
//                 : 0;
//         }

//         return $pourcentages;
//     }
//     private function getPourcentageTotal()
//     {
//         $frais = Frai::first();
//         if (!$frais) {
//             return 0; 
//         }
//         $nombreEtudiants = User::where('role', 'user')->count();

//         $montantAttenduTotal = ($frais->tranche1 + $frais->tranche2 + $frais->tranche3) * $nombreEtudiants;
//         $montantPayeTotal = Paiement::sum('montant_paye');

//         if ($montantAttenduTotal > 0) {
//             return round(($montantPayeTotal / $montantAttenduTotal) * 100, 1);
//         }

//         return 0;
//     }
// }



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