<?php

namespace App\Model;

use App\Model\User;
use App\Model\Offer;
use App\Model\Budget;
use App\Model\Message;
use App\model\Category;
use App\Model\Departement;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Projet extends Model implements Viewable
{
  protected $guarded = [];
  use InteractsWithViews;

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }

  public function departement()
  {
    return $this->belongsTo(Departement::class);
  }

  public function budget()
  {
    return $this->belongsTo(Budget::class);
  }

  public function offers()
  {
    return $this->hasMany(Offer::class);
  }

  public function messages()
  {
    return $this->belongsToMany(Message::class);
  }
}
