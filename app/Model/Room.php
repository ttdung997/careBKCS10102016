<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {

    protected $table = 'user_room';
    protected $fillable = [
        'name','room_number'
    ];

}
