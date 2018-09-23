<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\UserTransformer;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens, SoftDeletes;
    const ADMIN_USER = true;
    const REGULAR_USER = false;
    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;
    protected $table = 'users';
    public $transformer = UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'email',
         'password',
         'verified',
         'verification_token',
         'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttrinute($name)
    {
        return  ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public static function generateVerificationsCode()
    {
        return str_random(40);
    }
}
