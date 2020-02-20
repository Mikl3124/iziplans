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
        return $this->belongsToMany(Projet::class);
        }
}
