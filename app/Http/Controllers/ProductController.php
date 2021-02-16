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

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('image');
        if ($uploadFile) {
            $path = $uploadFile->store('public/img/health_agencies');
        } else {
            $path = null;
        }

        $health_agency = HealthAgency::create([
            'name' => $request->name,
            'address' => $request->address,
            'image' => $path,
            'call_center' => $request->call_center,
            'email' => $request->email,
        ]);

        if ($health_agency)
            return response()->json([
                'success' => true,
                'message' => 'Add data successfully!',
                'data' => $health_agency,
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], 500);
    }
}
