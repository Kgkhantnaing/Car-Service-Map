<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinCode extends Model
{
    public function scopeFindUsedPinCode($query, $oldPinCode)
    {
        return $query->where([
            ['pin', '=', $oldPinCode],
            ['is_used', '=', 1]
        ]);
    }

    public function scopeFindNewPinCode($query, $newPinCode)
    {
        return $query->where([
            ['pin', '=', $newPinCode],
            ['is_used', '=', 0]
        ]);
    }
}
