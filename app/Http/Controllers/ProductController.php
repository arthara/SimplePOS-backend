<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'total' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'cost_price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('image');
        if ($uploadFile) {
            $path = $uploadFile->store('public/img/products');
        } else {
            $path = null;
        }

        $product = Product::create([
            'name' => $request->name,
            'picture' => $path,
            'total' => $request->total,
            'selling_price' => $request->selling_price,
            'cost_price' => $request->cost_price,
        ]);

        if ($product)
            return response()->json([
                'success' => true,
                'message' => 'Add data successfully!',
                'data' => $product,
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'total' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'cost_price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('image');
        if ($uploadFile != null) {
            File::delete(storage_path('app/public/img/products/') . $product->image);
            $path = $uploadFile->store('public/img/products');
            $fileName = explode('/', $path);
            $fileName = end($fileName);
        } else {
            $fileName = $product->image;
        }

        $isUpdate = HealthAgency::where('id', $product->id)
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'image' => $fileName,
                'call_center' => $request->call_center,
                'email' => $request->email,
            ]);

        $data = Product::where('id', $product->id)->first();

        if ($isUpdate)
            return response()->json([
                'success' => true,
                'message' => 'Update data successfully!',
                'data' => $data,
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $data,
            ], 500);
    }
}
