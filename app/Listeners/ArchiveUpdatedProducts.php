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
        $latestProductHistory = $product->productHistory()->latest('id')->first();

        //if nothing or only total changed dont create new product history
        if($latestProductHistory->name == $product->name &&
            $latestProductHistory->cost_price == $product->cost_price &&
            $latestProductHistory->selling_price == $product->selling_price)
            return;

        //check if last product history has receipt item, if not delete it
        if($latestProductHistory->receipt_item->isEmpty())
            $latestProductHistory->delete();

        //save updated product as new history
        $productHistory = new ProductHistory();
        $productHistory->name = $product->name;
        $productHistory->cost_price = $product->cost_price;
        $productHistory->selling_price = $product->selling_price;
        $product->productHistory()->save($productHistory);
    }
}
