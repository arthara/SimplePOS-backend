<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReceiptResource;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $request->validate([
            // 'receipt_time' => 'date_format:Y-m-d H:i:s|required',
            'customer_name' => 'max:100|nullable',
            'customer_phone' => 'max:100|nullable',
            'tax' => 'max:100|nullable',
            'discount' => 'max:100|nullable',
            'other_charges' => 'max:100|nullable',
            'note' => 'max:100|nullable',
            'payment_method' => 'in:cash,debit_card,credit_card,ovo,gopay,shopeepay|required',
            'items' => 'array|required|min:1',
            'items.*.id' => 'required|integer',
            'items.*.unit_total' => 'required|integer'
        ]);

        $store = Auth::user()->store;

        DB::beginTransaction();
        try {
            $request->receipt_time = Carbon::parse($request->receipt_time);
            $receipt = new Receipt($request->all());
            $receipt->store()->associate($store);
            $receipt->save();

            $this->storeItems($store, $receipt, $request->items);
            DB::commit();
            return response()->json(new ReceiptResource($receipt), 201);
        }catch(\Exception $e){
            // cancel all insertion if there is any error
            DB::rollback();
            return response()->json([
                "message" => $e->getMessage(),
            ], 422);
        }
    }

    private function storeItems(Store $store, Receipt $receipt, $receipt_items){
        foreach($receipt_items as $item){
            $product = $store->product()
                            ->findOrFail($item["id"]);
            $product_history = $product->productHistory()
                                    ->latest("id")->first();

            $product->total -= $item["unit_total"];
            // if total bought item is more than total(stock) product
            if($product->total < 0)
                throw new \Exception("Total bought is more than available stock");
            $receipt_item = new ReceiptItem();

            $receipt_item->unit_total = $item["unit_total"];
            $receipt_item->productHistory()->associate($product_history);
            $receipt_item->receipt()->associate($receipt);
            $product->save();
            $receipt_item->save();
        }
    }
}
