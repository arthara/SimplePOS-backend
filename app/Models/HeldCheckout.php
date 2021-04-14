<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeldCheckout extends BaseModel
{
    /**
     * Get all of the heldCheckoutItem for the HeldCheckout
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function heldCheckoutItem(): HasMany
    {
        return $this->hasMany(HeldCheckoutItem::class);
    }

    /**
     * Get the store that owns the HeldCheckout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
