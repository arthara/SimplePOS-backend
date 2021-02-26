<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use Exception;

class ReceiptItemController extends Controller
{
    public function dailySales($inputDate){
        try{
            $date = Carbon::parse($inputDate);
        }catch(Exception $e){
            return $this->getInvalidDateResponse();
        }

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
            "date" => $inputDate,
            "total_sales" => $totalItem,
            "gross_profit" => $totalProfit,
        ], 200);
    }

    public function topSales($inputDate){
        try{
            $date = Carbon::parse($inputDate);
        }catch(Exception $e){
            return $this->getInvalidDateResponse();
        }

        $receipts = $this->getReceiptsWithCertainDate($date);

        //if no receipts found only return date
        if($receipts->isEmpty())
            return response()->json([
                "date" => $inputDate,
                "product" => null,
                "total_product" => 0,
                "category" => null,
                "total_category" =>  0,
            ], 200);

        return $this->countTopSales($receipts, $inputDate);
    }

    private function countTopSales($receipts, String $inputDate){
        $productsTotal = array();
        $categoriesTotal = array();

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
            "date" => $inputDate,
            "product" => Product::find($max_product_id[0]),
            "total_product" =>  $max_product,
            "category" => Category::find($max_category_id[0]),
            "total_category" =>  $max_category,
        ], 200);

    }

    private function getInvalidDateResponse(){
        return response()->json([
            "message" => "Invalid Date Received"
        ], 422);
    }

    private function getReceiptsWithCertainDate($date){
        $store = Auth::user()->store;

        return $store->receipt->whereBetween(
            'receipt_time', [$date->format('Y-m-d')." 00:00:00", $date->addDay()->format('Y-m-d')." 00:00:00"]
        );
    }
}
