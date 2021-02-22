<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    protected $table = 'categories';

    public $fillable = [
        "name", "color", "store_id"
    ];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
