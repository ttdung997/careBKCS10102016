<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table ='user_degree';
    protected $fillable = [
        'id','name'
    ];
}
