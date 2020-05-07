<?php

namespace App\Model;

use App\Model\Message;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
