<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    public $fillable = [
        "name", "category_id", "selling_price","cost_price"
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
