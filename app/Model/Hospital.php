<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
	protected $table ='hospital';
    protected $fillable = [
        'name', 'description'
    ];
}
