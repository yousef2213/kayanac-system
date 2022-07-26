<?php

namespace App\Http\Controllers;

use App\CRMCustomer;
use App\Employees;
use Illuminate\Http\Request;

class CRMCustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCustomers');
    }
    public function index()
    {
        $customers = CRMCustomer::paginate(10);

        return view('CRM.customers.index')->with("customers", $customers);
    }
    public function create()
    {
        $employees = Employees::where("occupation", "مندوب")->get();
        $employees->each(function ($item) {
            $item->name = $item->namear;
        });

        return view('CRM.customers.create')->with('employees', $employees);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namear' => 'string|required',
            'nameen' => 'string|required',
            'phone' => "required|unique:customers"
        ]);
        $data['name'] = $request->namear;
        $data['namear'] = $request->namear;
        $data['nameen'] = $request->nameen;
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
        $data['employee'] = $request->employee;
        $last = CRMCustomer::all()->last();
        $newId = 1;
        if ($last) {
            $newId = $last->id + 1;
        }
        $data['id'] = $newId;


        $status = CRMCustomer::create($data);
        $status->code = 200 + $status->id;
        $status->account_id = 990100 . $status->id;
        $status->save();

        return redirect()->route('crm-customers.index')->with('msg', 'Successfully Added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employees = Employees::where("occupation", "مندوب")->get();
        $employees->each(function ($item) {
            $item->name = $item->namear;
        });
        $custom = CRMCustomer::findOrFail($id);
        return view('CRM.customers.edit')->with('custom', $custom)->with('employees', $employees);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'namear' => 'string|required',
            'nameen' => 'string|required',
        ]);
        $customer = CRMCustomer::find($id);
        $customer->name = $request->namear;

        if ($request->VATRegistration) {
            $customer->VATRegistration = $request->VATRegistration;
        }
        if ($request->address) {
            $customer->address = $request->address;
        }
        if ($request->IdentificationNumber) {
            $customer->IdentificationNumber = $request->IdentificationNumber;
        }
        if ($request->phone) {
            $customer->phone = $request->phone;
        }

        if ($request->group) {
            $customer->group = $request->group;
        }
        if ($request->employee) {
            $customer->employee = $request->employee;
        }
        $customer->save();

        return redirect()->route('crm-customers.index')->with('msg', 'Successfully Updated');
    }

    public function destroy($id)
    {

        $delete = CRMCustomer::findorFail($id);

        $status = $delete->delete();

        return redirect()->route('crm-customers.index')->with('msg', 'Customer Successfully deleted');;
    }
}
