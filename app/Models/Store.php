<?php

namespace App\Models;

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
}
