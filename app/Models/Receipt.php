<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends BaseModel
{
    protected $fillable =[
        "receipt_time", "customer_name", "customer_phone",
        "tax", "discount", "other_charges", "note",
        "payment_method"
    ];

    public function receiptItem(){
        return $this->hasMany(ReceiptItem::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
