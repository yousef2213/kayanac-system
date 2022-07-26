<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Employees;
use App\OrderPages;
use App\Powers;
use App\SavedInvoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCustomers');
    }
    public function index()
    {
        $customers = Customers::paginate(10);
        $customers->each(function($el){
            $el->deleg = Employees::find($el->delegateId);
            if($el->deleg) {
                $el->delegName = Employees::find($el->delegateId)->namear;
            }else {
                $el->delegName  ="";
            }
        });
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCustomers" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCustomers" )->first();
        }
        return view('customers.index')
            ->with("orders", $orders)
            ->with("customers", $customers);
    }
    public function create()
    {
        $employees = Employees::where('occupation', 'مندوب')->get();
        return view('customers.create')->with('employees', $employees);
    }

    public function store(Request $request)
    {
        $is_credit_limit = 0;
        if (isset($request->is_credit_limit)) {
            $is_credit_limit = 1;
        }


        $this->validate($request, [
            'namecustomerar' => 'string|required',
            'namecustomeren' => 'string|required',
            'phone' => "required|unique:customers"
        ]);
        $data['name'] = $request->namecustomerar;
        $data['namear'] = $request->namecustomerar;
        $data['nameen'] = $request->namecustomeren;
        $data['phone'] = $request->phone;
        $data['is_credit_limit'] = $is_credit_limit;
        if ($request->group) {
            $data['group'] = $request->group;
        }

        if ($request->delegateId && $request->delegateId != "") {
            $data['delegateId'] = $request->delegateId;
        }
        if ($request->Obalance && $request->Obalance != "") {
            $data['Obalance'] = $request->Obalance;
        }
        if ($request->TObalance && $request->Obalance != "") {
            $data['TObalance'] = $request->TObalance;
        }
        if ($request->term_maturity && $request->Obalance != "") {
            $data['term_maturity'] = $request->term_maturity;
        }
        if ($request->credit_limit && $request->Obalance != "") {
            $data['credit_limit'] = $request->credit_limit;
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
        $data['type_invoice_electronice'] = $request->type_invoice_electronice;
        $last = Customers::all()->last();
        $newId = 1;
        if ($last) {
            $newId = $last->id + 1;
        }
        $data['id'] = $newId;


        $status = Customers::create($data);
        $status->code = 200 + $status->id;
        $status->account_id = 10100 . $status->id;
        $status->save();



        return redirect()->route('customers.index')->with('msg','Successfully added user');
    }
    public function createCustomer(Request $request)
    {
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $last = Customers::all()->last();
        $newId = 1;
        if ($last) {
            $newId = $last->id + 1;
        }
        $data['id'] = $newId;
        $status = Customers::create($data);
        $status->code = 200 + $status->id;
        $status->account_id = 10100 . $status->id;
        $status->save();

        $customrs = Customers::all();
        return response()->json([
            'status' => 200,
            'msg' => 'customer created',
            'customer' => $status,
            'customrs' => "moshen sssss",
        ]);
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employees = Employees::where('occupation', 'مندوب')->get();
        $custom = Customers::findOrFail($id);
        return view('customers.edit')->with('custom', $custom)->with('employees', $employees);
    }


    public function update(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'namecustomerar' => 'string|required',
            'namecustomeren' => 'string|required',
            'phone' => "required"
        ]);

        $is_credit_limit = 0;
        if (isset($request->is_credit_limit)) {
            $is_credit_limit = 1;
        }

        $customer = Customers::find($id);
        $customer->name = $request->namecustomerar;

        if ($request->group) {
            $customer->group = $request->group;
            $customer->save();
        }

        if ($request->delegateId && $request->delegateId != "") {
            $customer->delegateId = $request->delegateId;
            $customer->save();
        }
        if ($request->Obalance && $request->Obalance != "") {
            $customer->Obalance = $request->Obalance;
            $customer->save();
        }
        if ($request->TObalance && $request->Obalance != "") {
            $customer->TObalance = $request->TObalance;
            $customer->save();
        }
        if ($request->term_maturity && $request->Obalance != "") {
            $customer->term_maturity = $request->term_maturity;
            $customer->save();
        }
        if ($request->credit_limit && $request->Obalance != "") {
            $customer->credit_limit = $request->credit_limit;
            $customer->save();
        }


        if($request->IdentificationNumber && $request->IdentificationNumber != "") {
            $customer->IdentificationNumber = $request->IdentificationNumber;
            $customer->save();
        }
        if($request->address && $request->address != "") {
            $customer->address = $request->address;
            $customer->save();
        }
        if($request->VATRegistration && $request->VATRegistration != "") {
            $customer->VATRegistration = $request->VATRegistration;
            $customer->save();
        }
        if($request->phone && $request->phone != "") {
            $customer->phone = $request->phone;
            $customer->save();
        }
        if($request->type_invoice_electronice && $request->type_invoice_electronice != "") {
            $customer->type_invoice_electronice = $request->type_invoice_electronice;
            $customer->save();
        }
        if($request->type_invoice_electronice && $request->type_invoice_electronice != "") {
            $customer->type_invoice_electronice = $request->type_invoice_electronice;
            $customer->save();
        }

        $customer->is_credit_limit = $is_credit_limit;
        $customer->save();

        return redirect()->route('customers.index')->with('msg', 'Successfully Updated');
    }

    public function destroy($id)
    {

        $delete = Customers::findorFail($id);
        $Saves = SavedInvoices::where('customer_id', $id)->first();
        if ($Saves) {
            return redirect()->back()->with('success', ' لا يمكن حذف العميل لارتباطة بحركات ');
        }

        $delete->delete();
        return redirect()->route('customers.index')->with('msg', 'Customer Successfully deleted');
    }
}
