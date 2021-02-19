<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends BaseModel
{
    protected $fillable = [
        'receipt_id', 'product_id', 'unit_total', 'unit_price'
    ];

    public function receipt()
    {
        return $this->belongsTo('App\Models\Receipt');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
