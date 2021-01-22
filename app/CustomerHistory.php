<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerHistory extends Model
{
    protected $fillable = [
        'pin_id', 'customer_id', 'customer_phone_number', 'customer_name', 'is_claim','pin_flag'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function scopeCustomerHistoryById($query, $cusId)
    {
        return $query->where([
            ['customer_id', '=', $cusId]
        ]);
    }
}
