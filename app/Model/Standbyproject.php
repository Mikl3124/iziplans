<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Standbyproject extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
}
