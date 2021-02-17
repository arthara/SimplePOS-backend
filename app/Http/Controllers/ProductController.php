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
     * @param  \App\HealthAgency  $healthAgency
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, HealthAgency $healthAgency)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'call_center' => 'required',
            'email' => 'required|email|unique:health_agencies,email,' . $healthAgency->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('image');
        if ($uploadFile != null) {
            File::delete(storage_path('app/public/img/health_agencies/') . $healthAgency->image);
            $path = $uploadFile->store('public/img/health_agencies');
            $fileName = explode('/', $path);
            $fileName = end($fileName);
        } else {
            $fileName = $healthAgency->image;
        }

        $isUpdate = HealthAgency::where('id', $healthAgency->id)
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'image' => $fileName,
                'call_center' => $request->call_center,
                'email' => $request->email,
            ]);

        $health_agency = HealthAgency::where('id', $healthAgency->id)->first();

        if ($isUpdate)
            return response()->json([
                'success' => true,
                'message' => 'Update data successfully!',
                'data' => $health_agency,
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $health_agency,
            ], 500);
    }
}
