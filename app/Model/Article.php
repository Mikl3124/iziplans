<?php

namespace App\Model;

use App\Model\User;
use App\Model\Blogcategorie;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Article extends Model implements Viewable
{
  protected $guarded =[];
  use InteractsWithViews;

  public function user() {
    return $this->belongsTo('App\Model\User', 'user_id', 'id');
   }

  public function blogcategorie()
    {
        return $this->belongsToMany(Blogcategorie::class);
    }

}
