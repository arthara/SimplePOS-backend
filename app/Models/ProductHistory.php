<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
