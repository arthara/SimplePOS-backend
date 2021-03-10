<?php

namespace App\Listeners;

use App\Models\ProductHistory;
use App\Events\ArchiveNewProducts as ArchiveProductsEvent;

class ArchiveNewProducts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ArchiveProductsEvent $event)
    {
        $productHistory = new ProductHistory();
        $product = $event->product;
        $productHistory->name = $product->name;
        // if product cost price is null put default 0
        if(!$productHistory->cost_price = $product->cost_price)
            $productHistory->cost_price = 0;
        if(!$productHistory->selling_price = $product->selling_price)
            $productHistory->selling_price = 0;

        $product->productHistory()->save($productHistory);
    }
}
