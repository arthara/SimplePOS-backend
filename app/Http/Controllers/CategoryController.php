<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'color' => 'required|string',
            'categories_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'color' => $request->color,
            'categories_id' => $request->categories_id
        ]);

        if ($category)
            return response()->json([
                'success' => true,
                'message' => 'Add data successfully!',
                'data' => $category,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], 500);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $isUpdate = Category::where('id', $category->id)
            ->update([
                'name' => $request->name,
                'color' => $request->color,
            ]);

        $category_item = Category::where('id', $category->id)->first();

        if ($isUpdate)
            return response()->json([
                'success' => true,
                'message' => 'Update data successfully!',
                'data' => $category_item,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $category_item,
            ], 500);
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->delete()) {
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
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Store $store
     * @return JsonResponse|Response
     */
    public function getCategoriesOfCurrentStore(Store $store){
        $data = Category::where('store_id', $store->id)->first();

        if ($data)
            return response()->json([
                'success' => true,
                'message' => 'Get data successfully!',
                'data' => $data
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 500);
    }


}