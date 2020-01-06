<?php

namespace App\model;

use App\Model\Projet;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    public function projets()
        {
        return $this->belongsToMany(Projet::class);
        }
}
