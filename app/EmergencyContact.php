<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'name', 'phone', 'latitude', 'longitude', 'address','category_id','city','image'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $table = 'emergency_contact';
}
