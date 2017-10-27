<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table ='staffs';
	public $timestamps = false;
    protected $fillable = [
        'staff_id', 'phongban','khoa','chucvu','bangcap'
    ];
}
