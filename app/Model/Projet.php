<?php

namespace App\Model;

use App\Model\User;
use App\model\Category;
use App\model\Competence;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
        protected $guarded =[];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function competences()
    {
        return $this->belongsToMany(Competence::class);
    }
}
