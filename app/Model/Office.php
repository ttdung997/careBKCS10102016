<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Office extends Model {

    protected $table = 'user_office';
    protected $fillable = [
        'name','position_id'
    ];

}
