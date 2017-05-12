<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password','position','khoa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function medicalApplications()
    {
        return $this->hasMany('App\Model\MedicalApplication');
    }

    public function user_Role(){
        return $this->hasMany('App\Model\User_Role');
    }

    public function user_Permission(){
        return $this->hasMany('App\Model\User_Permission');
    }
}
