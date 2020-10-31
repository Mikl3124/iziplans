<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
  protected $guarded =[];

  public function user() {
    return $this->belongsTo('App\Model\User', 'user_id', 'id');
   }

}
