<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table ='roles';
    protected $fillable = [
        'name','description'
    ];

    public function user_Role(){
        return $this->hasMany('App\Model\User_Role');
    }

   public function role_Permission(){
        return $this->hasMany('App\Model\Role_Permission');
    }
}
