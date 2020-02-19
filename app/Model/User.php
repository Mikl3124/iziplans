<?php

namespace App\Model;

use App\Model\Offer;
use App\Model\Projet;
use App\model\Competence;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id',
        'role',
        'lastname',
        'firstname',
        'cgv',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        public function posts()
    {
        return $this->hasMany(Projet::class)->orderBy('created_at', 'DESC');

    }

        public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function getAvatar()
    {
        $avatarPath = $this->avatar ?? 'https://static.vecteezy.com/system/resources/previews/000/512/576/non_2x/vector-profile-glyph-black-icon.jpg';
        return $avatarPath;
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class);
    }

}
