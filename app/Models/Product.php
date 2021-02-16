<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    public $fillable = [
        "name"
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
