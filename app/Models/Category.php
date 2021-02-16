<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    public $fillable = [
        "name", "color"
    ];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
