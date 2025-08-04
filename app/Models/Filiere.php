<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function specialites()
    {
        return $this->hasMany(Specialite::class);
    }
}
