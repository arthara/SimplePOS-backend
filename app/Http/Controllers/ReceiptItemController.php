<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ReceiptItemController extends Controller
{
    public function dailySales($inputDate){
        $date = Carbon::parse($inputDate);

        $receipts = $this->getReceiptsWithCertainDate($date);
        $totalProfit = 0;
        $totalItem = 0;

        foreach($receipts as $receipt){
            foreach($receipt->receiptItem as $receiptItem){
                $totalItem += $receiptItem->unit_total;
                //profit += total item * (sold-cost)
                $totalProfit += $receiptItem->unit_total *
                    ($receiptItem->product_history->selling_price - $receiptItem->product_history->cost_price);
            }
            $totalProfit += $receipt->other_charges - $receipt->discount + $receipt->tax;
        }

        return response()->json([
            "Date" => $inputDate,
            "Total Sales" => $totalItem,
            "Laba Kotor" => $totalProfit,
        ], 200);
    }

    public function topSales($inputDate){
        $date = Carbon::parse($inputDate);
        $productsTotal = array();
        $categoriesTotal = array();
        $receipts = $this->getReceiptsWithCertainDate($date);

        //sum by product and sum by category and save id as array index
        foreach($receipts as $receipt){
            foreach($receipt->receiptItem as $receiptItem){
                //if product is already deleted, skip item
                if(!$product = $receiptItem->product_history->product)
                    continue;
                $productId = $product->id;
                $categoryId = $product->category->id;

                //check if it's already assigned, otherwise put total as 0
                if(!isset($productsTotal[$productId]))
                    $productsTotal[$productId] = 0;
                if(!isset($categoriesTotal[$categoryId]))
                    $categoriesTotal[$categoryId] = 0;

                $productsTotal[$productId] += $receiptItem->unit_total;
                $categoriesTotal[$categoryId] += $receiptItem->unit_total;
            }
        }

        $max_product = max($productsTotal);
        $max_category = max($categoriesTotal);
        $max_product_id = array_keys($productsTotal, $max_product, false);
        $max_category_id = array_keys($categoriesTotal, $max_category, false);

        //pick only the first if found more than 1 max
        return response()->json([
            "Date" => $inputDate,
            "Product" => Product::find($max_product_id[0]),
            "Total Product" =>  $max_product,
            "Category" => Category::find($max_category_id[0]),
            "Total Category" =>  $max_category,
        ], 200);
    }

    private function getReceiptsWithCertainDate($date){
        $store = Auth::user()->store;

        return $store->receipt->whereBetween(
            'receipt_time', [$date->format('Y-m-d')." 00:00:00", $date->addDay()->format('Y-m-d')." 00:00:00"]
        );
    }
}
