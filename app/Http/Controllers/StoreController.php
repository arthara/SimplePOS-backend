<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use Illuminate\Http\Request;
use App\Models\Store;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        return response()->json(new StoreResource($store), 201);
    }

    public function index(){
        $store = Auth::user()->store;

        return response()->json(new StoreResource($store));
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
            Storage::delete(Store::$LOGO_PATH. "/". $store->logo);
            $path = $uploadFile->store(Store::$LOGO_PATH);
            $fileName = explode('/', $path);
            $fileName = end($fileName);
        }else{
            $fileName = $store->logo;
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
            return response()->json(new StoreResource($data), 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
            ], 500);
    }

    public function updateNoteOfStore(Request $request, Store $store){
        $user = Auth::user();

        if ($user->id != $store->user_id)
            return response()->json(["message" => "user bukan pemilik toko"], 403);

        $validator = Validator::make($request->all(), [
            'note' => 'string|max:150|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $isUpdate = Store::where('id', $store->id)
            ->update([
                'note_receipt' => $request->note_receipt
            ]);

        $data = Store::where('id', $store->id)->first();

        if ($isUpdate)
            return response()->json(new StoreResource($data), 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
            ], 500);
    }

    public function updateImageOfStore(Request $request, Store $store)
    {
        $logo_name = null;
        $user = Auth::user();

        if ($user->id != $store->user_id)
            return response()->json(["message" => "user bukan pemilik toko"], 403);

        $validator = Validator::make($request->all(), [
            'logo' => 'max:2000|mimes:jpeg,jpg,png,svg|nullable', //max size 1mb
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Checking File
        $uploadFile = $request->file('logo');
        if ($uploadFile != null) {
            //File::delete(storage_path(Store::$LOGO_PATH) . $store->logo);
            Storage::delete(Store::$LOGO_PATH. "/". $store->logo);
            $path = $uploadFile->store(Store::$LOGO_PATH);
            $fileName = explode('/', $path);
            $fileName = end($fileName);
        }else{
            $fileName = $store->logo;
        }

        $isUpdate = Store::where('id', $store->id)
            ->update([
                'logo' => $fileName,
            ]);

        $data = Store::where('id', $store->id)->first();

        if ($isUpdate)
            return response()->json([
                'success' => true,
                'message' => 'Update data successfully!',
                'data' => new StoreResource($data),
            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Update data failed!',
            ], 500);
    }


    public function getLogo() {
        try {
            $store = Auth::user()
                ->store;

            if($store->logo == null)
                throw new Exception("Store doesnt have a logo yet");

            $path = Store::$LOGO_PATH."/".$store->logo;

            return Storage::download($path);
        }catch(\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

}
