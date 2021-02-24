<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductHistory extends BaseModel
{
    /**
     * Get all of the comments for the ProductHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipt_item(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }

    /**
     * Get the product that owns the ProductHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
