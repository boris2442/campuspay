<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Relations
     */
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function frais()
    {
        return $this->hasMany(Frai::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Attributs calculés (Accessors)
     */

    // Montant total payé par l'étudiant
    public function getTotalPayeAttribute()
    {
        return $this->paiements->sum('montant_paye');
    }

    // Montant total des frais (à partir du modèle Frai)
    public function getTotalFraisAttribute()
    {
        $frais = Frai::first(); // À adapter si frais par spécialité/filière
        return $frais?->total ?? 0;
    }

    // Solde restant à payer
    public function getFraisRestantAttribute()
    {
        return $this->total_frais - $this->total_paye;
    }

    // Statut global du paiement
    public function getStatutPaiementAttribute()
    {
        return $this->frais_restant <= 0 ? 'Complet' : 'En cours';
    }

    /**
     * Méthode pour savoir quelles tranches sont couvertes
     *
     * @return array Liste des tranches couvertes : ['tranche1', 'tranche2']
     */
    public function tranchesCouvertes()
    {
        $frais = Frai::first();
        if (!$frais) return [];

        $totalPaye = $this->total_paye;
        $tranches = [];

        if ($totalPaye >= $frais->tranche1) {
            $tranches[] = 'tranche1';
        }
        if ($totalPaye >= $frais->tranche1 + $frais->tranche2) {
            $tranches[] = 'tranche2';
        }
        if ($totalPaye >= $frais->total) {
            $tranches[] = 'tranche3';
        }

        return $tranches;
    }

    /**
     * Vérifie si une tranche spécifique est couverte
     *
     * @param string $tranche Ex: 'tranche1'
     * @return bool
     */
    public function aPayeTranche($tranche)
    {
        return in_array($tranche, $this->tranchesCouvertes());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_naissance',
        'role',
        'lieu_de_naissance',
        'telephone',
        'adresse',
        'prenom',
        'photo',
        'filiere_id',
        'specialite_id',
        'niveau_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}