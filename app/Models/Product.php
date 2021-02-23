<?php

namespace App\Models;

use App\Events\ArchiveNewProducts;
use App\Events\ArchiveUpdatedProducts;

class Product extends BaseModel
{
    protected $dispatchesEvents = [
        'created' => ArchiveNewProducts::class, //save new product to history
        'updated' => ArchiveUpdatedProducts::class, //save updated product with checking to old product history
    ];

    public function productHistory(){
        return $this->hasMany(ProductHistory::class);
    }
}
