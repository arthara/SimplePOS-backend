<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'receipt_time' => $this->receipt_time,
            "payment_method" => $this->payment_method,
            "store_id" => $this->store_id,
            "customer_name" => $this->customer_name,
            "customer_phone" => $this->customer_phone,
            "tax" => $this->tax,
            "discount" => $this->discount,
            "other_charges" => $this->other_charges,
            "note" => $this->note,
        ];
    }
}
