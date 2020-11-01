<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogcategorie extends Model
{
  protected $guarded =[];

  public function article()
    {
        return $this->belongsToMany(Article::class);
    }


}
