<?php

namespace App\Http\Controllers;

use App\OrderPages;
use App\Powers;
use App\Purchases;
use Illuminate\Http\Request;
use App\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierControler extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }
    public function index()
    {
        $customers = Supplier::paginate(10);
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsSuppliers" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsSuppliers" )->first();
        }
        return view('supplier.index')
                ->with("orders", $orders)
                ->with("customers", $customers);
    }
    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namecustomerar' => 'string|required',
            'namecustomeren' => 'string|required',
            'phone' => "required|unique:suppliers"
        ]);
        $data['name'] = $request->namecustomerar;
        $data['phone'] = $request->phone;
        if ($request->group) {
            $data['group'] = $request->group;
        }
        if ($request->numRegister) {
            $data['VATRegistration'] = $request->numRegister;
        }
        if ($request->IdentificationNumber) {
            $data['IdentificationNumber'] = $request->IdentificationNumber;
        }
        if ($request->IdentificationNumber) {
            $data['IdentificationNumber'] = $request->IdentificationNumber;
        }


        $data['address'] = $request->address;

        $last = Supplier::all()->last();
        $newId = 1;
        if ($last) {
            $newId = $last->id + 1;
        }

        $data['id'] = $newId;
        $status = Supplier::create($data);
        $status->code = 200 + $status->id;
        $status->account_id = 20100 . $status->id;
        $status->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('supplier.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $custom = Supplier::findOrFail($id);
        return view('supplier.edit')->with('custom', $custom);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'namecustomerar' => 'string|required|max:30',
            'namecustomeren' => 'string|required|max:30',
        ]);
        $customer = Supplier::find($id);
        $customer->name = $request->namecustomerar;
        $customer->group = $request->group;
        $customer->IdentificationNumber = $request->IdentificationNumber;
        $customer->VATRegistration = $request->numRegister;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->save();

        if ($customer) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('supplier.index');
    }

    public function destroy($id)
    {
        $delete = Supplier::findorFail($id);
        $Saves = Purchases::where('supplier', $id)->first();
        if ($Saves) {
            return redirect()->back()->with('msg', ' لا يمكن حذف المورد لارتباطة بحركات ');
        }
        $delete->delete();

        return redirect()->route('supplier.index')->with('msg', 'Successfully deleted');
    }
}
