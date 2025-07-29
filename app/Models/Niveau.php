<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $fillable = ['name', 'specialite_id', /* autres colonnes */];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }
}
