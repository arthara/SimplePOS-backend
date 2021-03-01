<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;

class CategoryController extends Controller
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
                ->category;
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
            //validate incoming request
            'name' => 'required|string|max:100',
            'color' => 'required|string|max:100',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->color = $request->color;

        Auth::user()
                ->store
                ->category()
                ->save($category);

        return response($category, 201);
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
                ->category()
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
        try{
            $category = Auth::user()
                        ->store
                        ->category()
                        ->findorFail($id);

            $request->validate([
                //validate incoming request
                'name' => 'string|max:100|nullable',
                'color' => 'string|max:100|nullable',
            ]);

            //if not null or not empty apply changes
            if($request->name)
                $category->name = $request->name;
            if($request->color)
                $category->color = $request->color;

            $category->save();
            return response()->json([
                $category
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }
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
                ->category()
                ->findorFail($id)
                ->delete();

            return response('', 204);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }
    }
}
