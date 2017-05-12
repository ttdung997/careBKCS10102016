<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
	protected $table ='doctors';
	public $timestamps = false;
    protected $fillable = [
        'khoa', 'chucvu', 'bangcap'
    ];
}
