<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\Http\Middleware\Authenticate;
use App\Invoices;
use App\OrderPages;
use App\RefUser;
use App\StoreModel;
use Illuminate\Support\Facades\Auth;

class BranchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsBranchs');
    }
    public function index()
    {
        $branches = Branches::paginate(10);
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsBranchs" )->first();
        if(!$orders) {
            $orders = 0;
        }
        return view('branches.index')->with('branches', $branches)->with('orders', $orders);
    }


    public function create()
    {
        $ref = RefUser::all()->first();
        $branches = Branches::all();
        if ($ref->ref == 1 || $ref->ref == 2) {
            if (count($branches) >= 1) {
                if($ref->ref == 1) $name =  "برونز ";
                if($ref->ref == 2) $name =  "سيلفر ";
                return redirect()->route('branches.index')->with('msg', "لا يمكن اضافة فرع اخر انت علي نسخة  " . $name);
            }
        }


        $companys = Compaines::paginate(10);
        return view('branches.create')->with('companys', $companys);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namear' => 'unique:branches|required',
            'phone' => 'unique:branches|required',
        ]);
        // return $request;
        $data['companyId'] = Compaines::find(1)->id;
        $data['namear'] = $request->namear;
        $data['nameen'] = $request->namear;
        $data['phone'] = $request->phone;

        $status = Branches::create($data);
        if ($request->code_activite) {
            $status->code_activite = $request->code_activite;
            $status->save();
        }
        if ($request->activite_code) {
            $status->activite_code = $request->activite_code;
            $status->save();
        }
        if ($status) {
            request()->session()->flash('success', 'Successfully added item');
        } else {
            request()->session()->flash('error', 'Error occurred while adding item');
        }
        return redirect()->route('branches.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $companys = Compaines::paginate(10);
        $item = Branches::findOrFail($id);
        return view('branches.edit')->with('item', $item)->with('companys', $companys);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'namear' => 'string|required',
            'nameen' => 'string',
        ]);
        $branche = Branches::findOrFail($id);
        $branche->namear = $request->namear;
        $branche->nameen = $request->nameen;
        $branche->companyId = $request->companyId;
        if ($request->city) {
            $branche->city = $request->city;
            $branche->save();
        }
        if ($request->region) {
            $branche->region = $request->region;
            $branche->save();
        }
        if ($request->country) {
            $branche->country = $request->country;
            $branche->save();
        }
        if ($request->activite_code) {
            $branche->activite_code = $request->activite_code;
            $branche->save();
        }
        if ($request->code_activite) {
            $branche->code_activite = $request->code_activite;
            $branche->save();
        }
        if ($request->address) {
            $branche->address = $request->address;
            $branche->save();
        }
        if ($request->phone) {
            $branche->phone = $request->phone;
            $branche->save();
        }
        $branche->save();
        return redirect()->route('branches.index')->with('success', 'Successfuly Updted');
    }

    public function destroy($id)
    {
        $delete = Branches::findorFail($id);

        $item = Invoices::where('branchId', $id)->first();
        $branch = StoreModel::where('branchId', $id)->first();
        if ($item || $branch) {
            return redirect()->back()->with('success', ' لا يمكن حذف الفرع لارتباطة بحركات ');
        }

        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('branches.index');
    }
}
