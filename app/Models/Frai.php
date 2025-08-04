<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frai extends Model
{
    //
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
