<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['customer_name', 'customer_phone_number', 'feedback_body'];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}