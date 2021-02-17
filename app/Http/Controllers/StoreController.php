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

        $request->validate([
            //validate incoming request
            'name' => 'required|string',
            'logo' => 'max:1000|mimes:jpeg,jpg,png', //max size 1mb
            'address' => 'string',
            'phone_number' => 'string',
        ]);

        //if uploaded file exist
        if ($logo =  $request->file("logo")){
            $logo_path = $logo->store(Store::$LOGO_PATH);
            //remove folder name from path
            $logo_name = str_replace(Store::$LOGO_PATH."/", '', $logo_path);
        }

        $userId = Auth::user()->id;
        $store = Store::create([
            'name' => $request->name,
            'logo' => $logo_name,
            'user_id' => $userId,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
        return response()->json($store, 201);
    }
}
