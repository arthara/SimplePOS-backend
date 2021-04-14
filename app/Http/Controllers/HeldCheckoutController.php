<?php

namespace App\Http\Controllers;

use App\Http\Resources\HeldCheckoutResource;
use App\Models\HeldCheckout;
use App\Models\HeldCheckoutItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeldCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heldCheckouts = Auth::user()
                            ->store
                            ->heldCheckout()
                            ->with("heldCheckoutItem")
                            ->get();

        return response()->json(
            HeldCheckoutResource::collection($heldCheckouts)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "items" => "array|required|min:1",
            'items.*.product_id' => 'required|integer',
            'items.*.unit_total' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $heldCheckout = new HeldCheckout();
            $heldCheckout->store()->associate(
                Auth::user()->store
            );
            $heldCheckout->save();

            $this->saveCheckoutItems($heldCheckout, $request->items);
            DB::commit();

            return response()->json(new HeldCheckoutResource($heldCheckout), 201);
        }catch (\Exception $e) {
            DB::rollback();
            abort(422, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HeldCheckout  $heldCheckout
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()
            ->store
            ->heldCheckout()
            ->findorFail($id)
            ->delete();

        return response("", 204);
    }

    private function saveCheckoutItems(HeldCheckout $heldCheckout, $checkoutItems) {
        foreach($checkoutItems as $checkoutItem) {
            $product = Auth::user()->store->product()->findOrfail($checkoutItem["product_id"]);
            $heldCheckoutItem = new HeldCheckoutItem($checkoutItem);

            if($product->total < $heldCheckoutItem->unit_total)
                throw new \Exception("Unit total must be less than product's total");

            $heldCheckoutItem->heldCheckout()->associate($heldCheckout);
            $heldCheckoutItem->product()->associate($product);
            $heldCheckoutItem->save();
        }
    }
}
