<?php

namespace App\Http\Controllers;

use App\Currencies;
use App\OrderPages;
use App\Powers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CurrenciesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCurrencies');
    }

    public function index()
    {
        $currencies = Currencies::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCurrencies" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCurrencies" )->first();
        }
        return view('currencies.index')
            ->with('orders', $orders)
            ->with('currencies', $currencies);
    }

    public function create()
    {
        return view('currencies.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            // 'namear' => 'required|unique:currencies',
            // 'nameen' => 'required|unique:currencies',
            'bigar' => 'required|unique:currencies',
            'bigen' => 'required|unique:currencies',
            'smallar' => 'required',
            'smallen' => 'required',
            'main' => 'required',
        ]);
        $rateV = 0;
        if (isset($request->rate)) {
            $rateV = $request->rate;
        } else {
            $rateV = 1;
        }

        $curr = Currencies::where('main', 1)->first();
        if($request->main == 1) {
            if($curr) return redirect()->back()->with('msg', 'لا يمكن جعل هذة العملة افتراضية يوجد عملة افتراضية');
        }

        Currencies::create([
            'namear' => $request->namear,
            'nameen' => $request->nameen,
            'bigar' => $request->bigar,
            'bigen' => $request->bigen,
            'smallar' => $request->smallar,
            'smallen' => $request->smallen,
            'tax_code' => $request->tax_code,
            'rate' => $rateV,
            'main' => $request->main,
        ]);

        return redirect()->route('currencies.index')->with('msg', 'Successfully added');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $currancy = Currencies::findOrFail($id);
        return view('currencies.edit')->with('currancy', $currancy);
    }

    public function update(Request $request, $id)
    {

        $currency = Currencies::find($id);

        $currency->namear = $request->namear;
        $currency->nameen = $request->nameen;
        $currency->bigar = $request->bigar;
        $currency->bigen = $request->bigen;
        $currency->smallar = $request->smallar;
        $currency->smallen = $request->smallen;
        $currency->tax_code = $request->tax_code;
        if (isset($currency->rate)) {
            $currency->rate = 1;
        }
        $currency->main = $request->main;
        $currency->save();
        return redirect()->route('currencies.index')->with('msg', 'Successfully updated');
    }

    public function destroy($id)
    {
        $delete = Currencies::findorFail($id);
        $delete->delete();
        return redirect()->route('currencies.index')->with('msg', 'User Successfully deleted');
    }
}
