<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalApplication extends Model
{
    protected $fillable = [
        'date', 'status', 'url'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
