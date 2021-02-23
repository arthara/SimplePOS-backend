<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReceiptItemController extends Controller
{
    public function dailySales($inputDate){
        $date = Carbon::parse($inputDate);
        $store = Auth::user()->store;

        if(!$store)
            return response()->json([
                "message" => "User's store is not found"
            ], 404);

        $receipts = $store->receipt->whereBetween(
            'receipt_time', [$date->format('Y-m-d')." 00:00:00", $date->addDay()->format('Y-m-d')." 00:00:00"]
        );
        $totalProfit = 0;
        $totalItem = 0;

        foreach($receipts as $receipt){
            foreach($receipt->receiptItem as $receiptItem){
                $totalItem += $receiptItem->unit_total;
                //profit += total item * (sold-cost)
                $totalProfit += $receiptItem->unit_total *
                    ($receiptItem->product_history->selling_price - $receiptItem->product_history->cost_price) ;
            }
            $totalProfit += $receipt->other_charges - $receipt->discount + $receipt->tax;
        }

        return response()->json([
            "Date" => $inputDate,
            "Total Sales" => $totalItem,
            "Laba Kotor" => $totalProfit,
        ], 200);
    }
}
