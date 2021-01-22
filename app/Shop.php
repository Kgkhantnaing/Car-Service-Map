<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'image_url', 'address', 'latitude', 'longitude', 'phone_no', 'city', 'remark', 'category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
