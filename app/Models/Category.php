<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [
        "name", "color"
    ];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function product(){
        return $this->hasMany('App\Models\Product');
    }
}
