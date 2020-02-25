<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content', 'from_id', 'to_id', 'read_at'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
