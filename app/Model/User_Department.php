<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User_Department extends Model
{
    protected $table ='user_department';
    protected $fillable = [
        'user_id','department_id'
    ];
}
