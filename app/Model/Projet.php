<?php

namespace App\Model;

use App\model\Category;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
        protected $guarded =[];
    
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function categories()
        {
        return $this->belongsToMany(Category::class);
        }
}
