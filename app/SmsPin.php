<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsPin extends Model
{
    protected $fillable = ['phone_number', 'sms_pin'];
}
