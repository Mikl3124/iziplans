<?php

namespace App\Model;

use App\Model\Message;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
