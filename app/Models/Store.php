<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Store extends BaseModel
{
    public static $LOGO_PATH = "store logos";
    //

    public $fillable = [
        "name", "logo", "address", "phone_number"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function receipt(){
        return $this->hasMany(Receipt::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    /**
     * Get all of the product for the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function product(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Category::class);
    }
}
