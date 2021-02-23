<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function receiptItem(){
        return $this->hasMany(ReceiptItem::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
