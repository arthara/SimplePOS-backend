<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceiptItem extends BaseModel
{
    public function receipt(): BelongsTo {
        return $this->belongsTo(Receipt::class);
    }

    /**
     * Get the product_history associated with the ReceiptItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_history(): BelongsTo
    {
        return $this->belongsTo(ProductHistory::class);
    }
}
