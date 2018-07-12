<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalSpecialistApplication extends Model
{
    protected $table = 'medical_specialist_applications';
    protected $fillable = [
        'date', 'status', 'url'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
