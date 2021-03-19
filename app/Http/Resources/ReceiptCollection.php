<?php

namespace App\Http\Resources;

use App\Models\Receipt;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReceiptCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection->transform(function(Receipt $receipt){
                return [
                    'id' => $receipt->id,
                    'receipt_time' => $receipt->receipt_time,
                    "payment_method" => $receipt->payment_method,
                    "total_item_sold" => $receipt->receiptItem->sum("unit_total"),
                    "profit" => $receipt->profit
                ];
            })
        ];
    }
}
