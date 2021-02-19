<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Display a listing of the resource.
     * @return Product[]|Collection|JsonResponse|Response
     */
    public function index()
    {
        $products = Product::paginate(8);

        if ($products)
            return response()->json([
                'success' => true,
                'message' => 'Get data success',
                'data' => $products,
            ], //200
                201
            );
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
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
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], //201
         500
        );
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
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
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

        $isUpdate = Product::where('id', $product->id)
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
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $data,
            ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse|Response
     * @throws Exception
     */

    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Delete data successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Delete data failed!',
            ], 201);
        }
    }


    /**
     * @return JsonResponse|Response
     */
    public function getAllProduct(){
        $products = Product::all();

        if ($products)
            return response()->json([
                'success' => true,
                'message' => 'Get data success',
                'data' => $products,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 201);
    }

    /**
     * @param Category $category
     * @return JsonResponse|Response
     */
    public function getAllProductOfCategory(Category $category)
    {
        $data = Product::where('category_id', $category->id)->first();

        if($data)
            return response()->json([
                'success' => true,
                'message' => 'Get data successfully!',
                'data' => $data
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 201);
    }
}
