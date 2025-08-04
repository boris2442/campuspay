<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    //
    protected $fillable = ['name', 'description', 'filiere_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }
    public function filiere()
{
    return $this->belongsTo(Filiere::class);
}

}
