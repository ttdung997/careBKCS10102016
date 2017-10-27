<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Infomation extends Model
{
	protected $table ='user_infomation';
	public $timestamps = false;
    protected $fillable = [
        'khoa_id', 'chucvu_id', 'bangcap_id','phongban_id'
    ];
}
