<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    
    function shops(){
        return $this->hasMany(Shop::class);
    }
}
