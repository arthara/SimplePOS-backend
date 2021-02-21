<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

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
        return Auth::user()->store;
    }
}
