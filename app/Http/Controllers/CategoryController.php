<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     * @return Category[]|Collection|JsonResponse|Response
     */
    public function index()
    {
        $category = Category::paginate(8);

        if ($category)
            return response()->json([
                'success' => true,
                'message' => 'Get data success',
                'data' => $category,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 204);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'color' => 'required|string',

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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse|Response
     */
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

    /**
     * @param Category $category
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
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
    }

    /**
     * @return JsonResponse|Response
     */
    public function getAllCategory(){
        $categories = Category::all();

        if ($categories)
            return response()->json([
                'success' => true,
                'message' => 'Get data success',
                'data' => $categories,
            ], 201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Data is empty!',
            ], 204);
    }


    /**
     * @param Store $store
     * @return JsonResponse|Response
     */
    public function getCategoriesOfCurrentStore(Store $store)
    {
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
            ], 204);
    }


}
