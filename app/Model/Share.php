<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $table ='share';
    protected $fillable = [
        'resource_owner','role_id','resource_id'
    ];
}
