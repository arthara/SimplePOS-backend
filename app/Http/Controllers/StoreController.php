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

        if ($logo =  $request->file("logo")){
            $logo_name = $logo->store(Store::$LOGO_PATH);
        }

        $userId = Auth::user()->id;
        $store = Store::create([
            'name' => $request->name,
            'logo' => $logo_name,
            'users_id' => $userId,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
        return response()->json($store, 201);
    }
}
