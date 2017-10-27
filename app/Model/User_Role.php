<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User_Role extends Model
{
    protected $table ='user_role';
    protected $fillable = [
        'user_id','role_id'
    ];
    
}
