<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReceiptItemController extends Controller
{
    public function dailySales($date){
        $date = Carbon::parse($date);
        $store = Auth::user()->store;

        if(!$store)
            return response()->json([
                "message" => "User's store is not found"
            ], 404);

        $receipts = $store->receipt->whereBetween(
            'receipt_time', [$date->format('Y-m-d')." 00:00:00", $date->addDay()->format('Y-m-d')." 00:00:00"]
        );
        $totalSales = 0;
        $totalItem = 0;

        foreach($receipts as $receipt){
            foreach($receipt->receiptItem as $receiptItem){
                $totalItem++;
                $totalSales += ($receiptItem->unit_price * $receiptItem->product->cost_price) * $receiptItem->unit_total;
            }
            $totalSales += $receipt->other_charges - $receipt->discount;
        }

        return response()->json([
            "Date" => $date,
            "Total Sales" => $totalItem,
            "Laba Kotor" => $totalSales,
        ], 200);
    }
}
