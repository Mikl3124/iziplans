<?php

namespace App\Model;

use App\Model\User;
use App\Model\Projet;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'departement_id');
    }

    public function standbyprojects()
        {
        return $this->hasMany(Standbyproject::class, 'departement_id');
        }
}
