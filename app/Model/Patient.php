<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table ='patients';
	public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
