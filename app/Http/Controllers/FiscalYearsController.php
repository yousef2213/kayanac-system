<?php

namespace App\Http\Controllers;

use App\FiscalYears;
use App\OrderPages;
use App\Powers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FiscalYearsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsFiscalYears');
    }

    public function index()
    {
        $fiscalYears = FiscalYears::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsFiscalYears" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsFiscalYears" )->first();
        }
        return view('fiscalYears.index')
        ->with('orders', $orders)
        ->with('fiscalYears', $fiscalYears);
    }

    public function create()
    {
        return view('fiscalYears.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|unique:fiscal_years',
            'start' => 'required|unique:fiscal_years',
            'end' => 'required|unique:fiscal_years',
            'status' => 'required|in:0,1',
        ]);
        FiscalYears::create([
            'code' => $request->code,
            'status' => $request->status,
            'start' => $request->start,
            'end' => $request->end,
            'notes' => $request->notes,
        ]);

        return redirect()->route('fiscal_years.index')->with('msg', 'Successfully added');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $fiscal = FiscalYears::findOrFail($id);
        return view('fiscalYears.edit')->with('fiscal', $fiscal);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'code' => 'required',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $fiscal = FiscalYears::find($id);

        $fiscal->code = $request->code;
        $fiscal->start = $request->start;
        $fiscal->end = $request->end;
        $fiscal->status = $request->status;
        $fiscal->save();
        return redirect()->route('fiscal_years.index')->with('msg', 'Successfully updated');
    }

    public function destroy($id)
    {
        $delete = FiscalYears::findorFail($id);
        $delete->delete();
        return redirect()->route('fiscal_years.index')->with('msg', 'User Successfully deleted');
    }
}
