<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = ['name', 'phone_number', 'password', 'token', 'pin_code', 'type', 'user_photo'];
    function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function scopeGetCustomerByPhoneAndOldPin($query, $phone, $oldPincode)
    {
        return $query->where([
            ['phone_number', '=', $phone],
            ['pin_code', '=', $oldPincode]
        ]);
    }
}
