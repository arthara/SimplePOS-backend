<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Receipt extends BaseModel
{
    protected $fillable =[
        "receipt_time", "customer_name", "customer_phone",
        "tax", "discount", "other_charges", "note",
        "payment_method"
    ];

    protected $appends = ["profit"];

    public function receiptItem(){
        return $this->hasMany(ReceiptItem::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function scopeDaily($query, Carbon $date){
        return $query->whereBetween(
            'receipt_time', [$date->format('Y-m-d')." 00:00:00", $date->addDay()->format('Y-m-d')." 00:00:00"]
        );
    }

    public function getProfitAttribute(){
        $profit = 0;
        $profit -= $this->discount;

        foreach($this->receiptItem as $receiptItem) {
            $sold_item = $receiptItem->unit_total;

            $profit += $receiptItem->productHistory->selling_price * $sold_item;
            $profit -= $receiptItem->productHistory->cost_price * $sold_item;
        }

        return $profit;
    }
}
