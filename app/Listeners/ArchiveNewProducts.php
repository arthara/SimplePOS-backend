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
        $productHistory->cost_price = $product->cost_price;
        $productHistory->selling_price = $product->sold_price;
        $product->productHistory()->save($productHistory);
    }
}
