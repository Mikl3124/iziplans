<?php

namespace App\Model;

use App\Model\User;
use App\Model\Projet;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
  protected $guarded =[];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function projet()
  {
    return $this->belongsTo(Projet::class);
  }
  
}
