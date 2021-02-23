<?php

namespace App\Listeners;

use App\Events\ArchiveUpdatedProducts as ArchiveUpdatedProductsEvent;
use App\Models\ProductHistory;

class ArchiveUpdatedProducts
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
    public function handle(ArchiveUpdatedProductsEvent $event)
    {
        $product = $event->product;
        //check if last product history has receipt item, if not delete it
        if($latestProductHistory = $product->productHistory->last()){
            if($latestProductHistory->receipt_item)
                $latestProductHistory->delete();
        }

        //save updated product as history
        $productHistory = new ProductHistory();
        $productHistory->name = $product->name;
        $productHistory->cost_price = $product->cost_price;
        $productHistory->selling_price = $product->sold_price;
        $product->productHistory()->save($productHistory);
    }
}
