<?php

namespace App\Model;

use App\Model\Projet;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function projets()
    {
        return $this->hasMany(Projet::class, 'budget_id');
    }
}
