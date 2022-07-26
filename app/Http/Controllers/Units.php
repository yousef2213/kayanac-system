<?php

namespace App\Http\Controllers;

use App\SavedInvoices;
use App\Unit;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Units extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsUnits');
        $this->middleware('active_permision');
    }

    public function index() {
        $units = Unit::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsUnits" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsUnits" )->first();
        }
        return view('Units.index')->with('orders', $orders)->with('units', $units);
    }

    public function add() {
        $units = Unit::paginate(10);
        return view('Units.add')->with('units', $units);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'namear'=> 'string|required|max:30',
            'nameen'=> 'string|max:30',
        ]);
        $data =  $request->all();

        Unit::create($data);
        return redirect()->route('units');
    }

    public function edit($id) {
        $unit = Unit::findOrFail($id);
        return view('Units.edit')->with('unit',$unit);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'namear'=> 'string|required|max:30',
            'nameen'=> 'string|max:30',
        ]);
        $unit = Unit::findOrFail($request->id);
        $unit->namear = $request->namear;
        $unit->nameen = $request->nameen;
        $unit->tax_code = $request->tax_code;
        $unit->save();

        return redirect()->route('units');
    }



    public function destroy($id) {
        $check = SavedInvoices::where("unit_id", $id)->first();
        $check2 = Itemslist::where("unitId", $id)->first();
        if($check) {
            return redirect()->back()->with('msg', ' لا يمكن حذف الوحدة لارتباطها بحركات');
        }

        if($check2) {
            return redirect()->back()->with('msg', ' لا يمكن حذف الوحدة لارتباطها بحركات');
        }
        $delete = Unit::findorFail($id);
        $delete->delete();
        return redirect()->route('units')->with('success', ' تم حذف الوحدة');

    }

}
