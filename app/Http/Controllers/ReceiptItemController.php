<?php

namespace App\Http\Controllers;

use App\Models\ReceiptItem;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReceiptItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function index()
    {
        $receipt_items = ReceiptItem::paginate(8);

        if ($receipt_items)
            return response()->json([
                'success' => true,
                'message' => 'Get data success',
                'data' => $receipt_items,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 204);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receipt_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'unit_total' => 'required',
            'unit_price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $receiptItem = ReceiptItem::create([
            'receipt_id' => $request->receipt_id,
            'product_id' => $request->product_id,
            'unit_total' => $request->unit_total,
            'unit_price' => $request->unit_price
        ]);

        if ($receiptItem)
            return response()->json([
                'success' => true,
                'message' => 'Add data successfully!',
                'data' => $receiptItem,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ReceiptItem  $receiptItem
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function update(Request $request, $receiptItem)
    {
        $validator = Validator::make($request->all(), [
            'receipt_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'unit_total' => 'required',
            'unit_price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $isUpdate = ReceiptItem::where('id', $receiptItem->id)
            ->update([
                'receipt_id' => $request->receipt_id,
                'product_id' => $request->product_id,
                'unit_total' => $request->unit_total,
                'unit_price' => $request->unit_price
            ]);

        $receipt_item = ReceiptItem::where('id', $receiptItem->id)->first();

        if ($isUpdate)
            return response()->json([
                'success' => true,
                'message' => 'Update data successfully!',
                'data' => $receipt_item,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $receipt_item,
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReceiptItem $receiptItem
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function destroy($receiptItem)
    {
        if ($receiptItem->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Delete data successfully!',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Delete data failed!',
            ], 500);
        }
    }
}
