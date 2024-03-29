<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Store extends BaseModel
{
    public static $LOGO_PATH = "store logos";
    //

    public $fillable = [
        "name", "logo", "address", "phone_number", "note"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function receipt(){
        return $this->hasMany(Receipt::class);
    }

    public function dailyReceipts(Carbon $date){
        return $this->receipt()->daily($date);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function heldCheckout(): HasMany
    {
        return $this->hasMany(HeldCheckout::class);
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
