<?php
namespace App\Model;

use App\Model\Offer;
use App\Model\Projet;
use App\Model\Thread;
use App\Model\Article;
use App\model\Category;
use App\model\Competence;
use App\Model\Departement;
use App\Model\Information;
use Laravel\Cashier\Billable;
use App\Notifications\PasswordReset;
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
    protected $guarded = [];


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

        public function projets()
    {
        return $this->hasMany(Projet::class);

    }

        public function offers()
    {
        return $this->hasMany(Offer::class);
    }
       public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getAvatar()
    {
        $avatarPath = $this->avatar ?? 'https://static.vecteezy.com/system/resources/previews/000/512/576/non_2x/vector-profile-glyph-black-icon.jpg';
        return $avatarPath;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function departements()
    {
        return $this->belongsToMany(Departement::class);
    }

    public function informations()
    {
        return $this->hasMany(Information::class);
    }

}
