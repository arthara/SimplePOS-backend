<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeldCheckoutItem extends BaseModel
{
    protected $fillable = [
        "unit_total"
    ];

    /**
     * Get the product that owns the HeldCheckoutItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the heldCheckout that owns the HeldCheckoutItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function heldCheckout(): BelongsTo
    {
        return $this->belongsTo(HeldCheckout::class);
    }
}
