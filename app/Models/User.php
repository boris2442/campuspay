<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
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
