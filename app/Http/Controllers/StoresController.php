<?php

namespace App\Http\Controllers;

use App\Branches;
use App\OrderPages;
use App\Powers;
use App\RefUser;
use App\StoreModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsDefinitionStores');
        $this->middleware('active_permision');
    }
    public function index()
    {
        $stores = StoreModel::paginate(10);
        $branches = Branches::all();

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsDefinitionStores" )->first();
        if(!$orders) {
                $columns = \Schema::getColumnListing('powers');
                $loginUser = Auth::user();
                $data['user_id'] = $loginUser->id;
                $power = Powers::create($data);
                if($loginUser->type == 3){
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            $power[$column] = 1;
                            $power->save();
                        }
                    }
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 1,
                                "add" => 1,
                                "edit" => 1,
                                "delete" => 1,
                            ]);
                        }
                    }
                }
                else {
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 0,
                                "add" => 0,
                                "edit" => 0,
                                "delete" => 0,
                            ]);
                        }
                    }
                }
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsDefinitionStores" )->first();
        }

        return view('stores.index')->with('orders', $orders)->with('stores', $stores)->with('branches', $branches);
    }

    public function create()
    {
        $ref = RefUser::all()->first();
        $stores = StoreModel::all();
        // if ($ref->ref == 1 || $ref->ref == 2) {
        //     if (count($stores) >= 1) {
        //         if ($ref->ref == 1) $name =  "برونز ";
        //         if ($ref->ref == 2) $name =  "سيلفر ";
        //         return redirect()->route('stores.index')->with('msg', "لا يمكن اضافة مخزن اخر انت علي نسخة  " . $name);
        //     }
        // }
        $branches = Branches::all();
        return view('stores.craete')->with('branches', $branches);
    }


    public function store(Request $request)
    {
        $barcnhes = implode(",", $request->branchId);
        $this->validate($request, [
            'namear' => 'required',
            'branchId' => 'required'
        ]);
        $data['branchId'] = $barcnhes;
        $data['namear'] = $request->namear;
        $data['nameen'] = $request->nameen;
        $data['active'] = $request->active;
        // $data = $request->all();

        if ($request->active == "on") {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }
        $store = StoreModel::create($data);



        if ($store) {
            return redirect()->route('stores.index');
        } else {
            return redirect()->back();
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $item = StoreModel::find($id);
        $branches = Branches::all();
        return view('stores.edit')->with('branches', $branches)->with('item', $item);
    }

    public function update(Request $request, $id)
    {
        $barcnhes = implode(",", $request->branchId);

        $this->validate($request, [
            'namear' => 'required',
            'branchId' => 'required'
        ]);
        $store = StoreModel::find($id);
        $store->namear = $request->namear;
        $store->nameen = $request->nameen;
        $store->branchId = $barcnhes;
        if ($request->active == "on") {
            $store->active = 1;
        } else {
            $store->active = 0;
        }
        $store->save();
        return redirect()->route('stores.index');
        //
    }


    public function destroy($id)
    {
        $store = StoreModel::find($id);
        $store->delete();
        return redirect()->route('stores.index');
    }
}
