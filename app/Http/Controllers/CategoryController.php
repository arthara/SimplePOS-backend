<?php

namespace App\Http\Controllers;

use App\Category;
use App\HealthAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'health_agency_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        if ($category)
            return response()->json([
                'success' => true,
                'message' => 'Add data successfully!',
                'data' => $category,
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Add data failed!',
            ], 500);
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Delete data successfully!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Delete data failed!',
            ], 500);
        }
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
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
                'data' => $category_item,
            ], 500);
    }

}
