<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function store(Request $request){
        $logo_name = null;
        $user = Auth::user();

        if($user->store)
            return response()->json([
                "message" => "User already has a store",
            ], 409);

        $request->validate([
            //validate incoming request
            'name' => 'required|string|max:100',
            'logo' => 'max:2000|mimes:jpeg,jpg,png,svg|nullable', //max size 1mb
            'address' => 'string|max:100|nullable',
            'phone_number' => 'string|max:100|nullable',
        ]);

        //if uploaded file exist
        if ($logo =  $request->file("logo")){
            $logo_path = $logo->store(Store::$LOGO_PATH);
            //remove folder name from path
            $logo_name = str_replace(Store::$LOGO_PATH."/", '', $logo_path);
        }

        $store = new Store();
        $store->name = $request->name;
        $store->logo = $logo_name;
        $store->address = $request->address;
        $store->phone_number = $request->phone_number;

        $user->store()->save($store);
        return response()->json($store, 201);
    }

    public function index(){
        $store = Auth::user()->store;

        return $store;
    }

    public function update(Request $request, Store $store){
        $logo_name = null;
        $user = Auth::user();

        if ($user->id != $store->user_id)
            return response()->json(["message" => "user bukan pemilik toko"], 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'logo' => 'max:2000|mimes:jpeg,jpg,png,svg|nullable', //max size 1mb
            'address' => 'string|max:100|nullable',
            'phone_number' => 'string|max:100|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('logo');
        if ($uploadFile != null) {
            File::delete(storage_path(Store::$LOGO_PATH) . $store->logo);
            $path = $uploadFile->store(Store::$LOGO_PATH);
            $fileName = explode('/', $path);
            $fileName = end($fileName);
        }else{
            $fileName = $store->image;
        }

        $isUpdate = Store::where('id', $store->id)
            ->update([
                'name' => $request->name,
                'logo' => $fileName,
                'address' => $request->address,
                'phone_number' => $request->phone_number
            ]);

        $data = Store::where('id', $store->id)->first();

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
            ], 500);
    }
}
