<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
  // Dans app/Models/Paiement.php
protected $fillable = ['user_id', 'frais_id', 'tranche_paye', 'montant_paye', 'mode_paiement'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function frai()
    {
        return $this->belongsTo(Frai::class);
    }
}
