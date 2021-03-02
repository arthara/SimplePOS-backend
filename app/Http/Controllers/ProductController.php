<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()
                ->store
                ->product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $picture_name = null;
        $request->validate([
            //validate incoming request
            'name' => 'required|string|max:100',
            'picture' => 'max:2000|mimes:jpeg,jpg,png,svg|nullable', //max size 2mb,
            'total' => 'required|integer|min:0', //value must be > 0
            'selling_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'category_id' => 'required|integer'
        ]);

        if(!$this->isCategoryIdValid($request->category_id))
            return response()->json([
                "message" => "Category Id is not valid"
            ], 422);

        //if uploaded file exist
        if ($picture =  $request->file("picture")){
            $picture_path = $picture->store(Product::$PICTURE_PATH);
            //remove folder name from path
            $picture_name = str_replace(Product::$PICTURE_PATH."/", '', $picture_path);
        }

        $product = new Product();
        $product->picture = $picture_name;
        $product->total = $request->total;
        $product->selling_price = $request->selling_price;
        $product->cost_price = $request->cost_price;
        $product->name = $request->name;

        Category::find($request->category_id)
            ->product()->save($product);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            return Auth::user()
                    ->store
                    ->product()
                    ->findOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate incoming request
        $request->validate([
            'name' => 'string|max:100|nullable',
            'picture' => 'max:2000|mimes:jpeg,jpg,png,svg|nullable', //max size 2mb,
            'total' => 'integer|min:0|nullable', //value must be > 0
            'selling_price' => 'numeric|min:0|nullable',
            'cost_price' => 'numeric|min:0|nullable',
            'category_id' => 'integer|nullable'
        ]);

        try{
            $product = Auth::user()->store->product()->findorFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }

        //if category id isnt null
        if($category_id = $request->category_id){
            if(!$this->isCategoryIdValid($category_id))
                return response()->json([
                    "message" => "Category Id is not valid"
                ], 422);
            else
                $product->category_id = $request->category_id;
        }

        //if uploaded file exist
        if ($picture =  $request->file("picture")){
            //if product already has logo
            if($product->picture)
                Storage::delete(Product::$PICTURE_PATH."/".$product->picture);

            $picture_path = $picture->store(Product::$PICTURE_PATH);
            //remove folder name from path
            $product->picture = str_replace(Product::$PICTURE_PATH."/", '', $picture_path);
        }

        $this->renewProduct($product, $request);
        $product->save();
        return response()->json(new ProductResource($product), 200);
    }

    private function renewProduct(Product $product, Request $request){
        //nullcheck
        if($request->name)
            $product->name = $request->name;
        if($request->total)
            $product->total = $request->total;
        if($request->selling_price)
            $product->selling_price = $request->selling_price;
        if($request->cost_price)
            $product->cost_price = $request->cost_price;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Auth::user()
                ->store
                ->product()
                ->findorFail($id)
                ->delete();

            return response('', 204);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }
    }

    private function isCategoryIdValid($id): bool{
        $categories = Auth::user()
                        ->store
                        ->category;

        foreach($categories as $category){
            if($category->id == $id)
                return true;
        }

        return false;
    }
}
