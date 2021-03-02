<?php

namespace App\Models;

use App\Events\ArchiveNewProducts;
use App\Events\ArchiveUpdatedProducts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    public static $PICTURE_PATH = "products picture";

    protected $dispatchesEvents = [
        'created' => ArchiveNewProducts::class, //save new product to history
        'updated' => ArchiveUpdatedProducts::class, //save updated product with checking to old product history
    ];

    public function productHistory(){
        return $this->hasMany(ProductHistory::class);
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
