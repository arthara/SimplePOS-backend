<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public static $LOGO_PATH = "store logos";
    //

    public $fillable = [
        "name", "logo", "address", "phone_number", "users_id"
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
