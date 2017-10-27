<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $table ='oidcclients';
	public $timestamps = false;
	protected $fillable = [
        'role_id', 'client_name'
    ];
}
