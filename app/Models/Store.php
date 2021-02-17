<?php

namespace App\Models;

class Store extends BaseModel
{
    public static $LOGO_PATH = "store logos";
    //

    public $fillable = [
        "name", "logo", "address", "phone_number", "user_id"
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
