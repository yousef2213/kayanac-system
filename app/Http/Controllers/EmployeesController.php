<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Customers;
use App\Employees;
use App\Invoices;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsEmployees');
    }

    public function index()
    {
        $employees = Employees::all();
        $employees->each(function ($employee) {
            $employee->barnch_name = Branches::find($employee->branchId)->namear;
        });
        // return $employees;
        return view('employees.index')->with('employees', $employees);
    }

    public function create()
    {
        $branches = Branches::all();
        return view('employees.create')->with('branches', $branches);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'namear' => 'required|unique:employees',
            'nameen' => 'required|unique:employees',
            'occupation' => 'required',
            "branchId" => "required",
            'status' => 'required|in:1,2',
        ]);

        $type = "";
        if ($request->status == 1) {
            $type = "نشط";
        } elseif ($request->status == 1) {
            $type = "موقوف";
        } elseif ($request->status == 3) {
            $type = "استقالة";
        } elseif ($request->status == 4) {
            $type = "اجازة سنوية";
        }
        $status = Employees::create([
            'namear' => $request->namear,
            'nameen' => $request->nameen,
            'occupation' => $request->occupation,
            'branchId' => $request->branchId,
            'status' => $request->status,
            'status_type' => $type,
        ]);
        $status->account_id = 40100 . $status->id;
        $status->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('employees.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $employee = Employees::findOrFail($id);
        return view('employees.edit')->with('employee', $employee)->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {

        $employee = Employees::find($id);
        $type = "";
        if ($request->status == 1) {
            $type = "نشط";
        } elseif ($request->status == 1) {
            $type = "موقوف";
        } elseif ($request->status == 3) {
            $type = "استقالة";
        } elseif ($request->status == 4) {
            $type = "اجازة سنوية";
        }
        $employee->namear = $request->namear;
        $employee->nameen = $request->nameen;
        $employee->branchId = $request->branchId;
        $employee->occupation = $request->occupation;
        $employee->status = $request->status;
        $employee->status_type = $type;
        $employee->save();
        return redirect()->route('employees.index')->with('msg', 'Successfully updated');
    }

    public function destroy($id)
    {
        $Del = Customers::where('delegateId', $id)->first();
        $Saved = Invoices::where('delegateId', $id)->first();

        if ($Del) {
            return redirect()->back()->with('msg', ' لا يمكن حذف الموظف لارتباطة بحركات ');
        }
        if ($Saved) {
            return redirect()->back()->with('msg', ' لا يمكن حذف الموظف لارتباطة بحركات ');
        }

        $delete = Employees::findorFail($id);
        $delete->delete();
        return redirect()->route('employees.index')->with('msg', 'User Successfully deleted');
    }
}
