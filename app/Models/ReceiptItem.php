<?php

namespace App\Models;

class ReceiptItem extends BaseModel
{
    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}
