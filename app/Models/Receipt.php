<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends BaseModel
{
    protected $fillable = [
        'store_id', 'receipt_time', 'payment_method',
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }
}
