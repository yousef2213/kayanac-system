<?php

namespace App\Http\Controllers;

use App\Compaines;
use App\OrderPages;
use App\Powers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CompainesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCompany');
    }
    public function index()
    {
        $comp = Compaines::paginate(10);
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCompany" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCompany" )->first();
        }

        return view('compines.index')->with('companys', $comp)
        ->with('orders', $orders);
    }

    public function create()
    {
        return view('compines.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'namear' => 'string|required|max:50',
            'nameen' => 'string|required|max:50',
            'active' => 'required',
            'logo' => 'nullable',
        ]);
        $data = $request->all();
        $data['companyNameAr'] = $request->namear;
        $data['companyNameEn'] = $request->nameen;
        $data['taxNum'] = $request->taxNum;
        $status = Compaines::create($data);
        if ($request->has('logo')) {
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('logo')->move(public_path('/comp'), $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $status->logo = $fileNameToStore;
        $status->save();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'Company successfully added');
        } else {
            request()
                ->session()
                ->flash('error', 'Error occurred while adding Company');
        }
        return redirect()->route('compaines.index');
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $company = Compaines::findOrFail($id);
        return view('compines.edit')->with('company', $company);
    }

    public function update(Request $request, $id)
    {
        $comp = Compaines::findorFail($id);
        $comp->companyNameAr = $request->namear;
        $comp->companyNameEn = $request->nameen;
        $comp->taxNum = $request->taxNum;
        $comp->negative_sale = $request->negative_sale;
        $comp->active = $request->active;

        $comp->token_serial_name = $request->token_serial_name;
        $comp->token_pin_password = $request->token_pin_password;
        $comp->client_id = $request->client_id;
        $comp->client_secret = $request->client_secret;
        if($request->tax_source) {
            $comp->tax_source = 1;
            $comp->save();
        }else {
            $comp->tax_source = 0;
            $comp->save();
        }

        if($request->tobacco_tax) {
            $comp->tobacco_tax = 1;
            $comp->save();
        }else {
            $comp->tobacco_tax = 0;
            $comp->save();
        }


        if ($request->has('logo')) {
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('logo')->move(public_path('/comp'), $fileNameToStore);
            $comp->logo = $fileNameToStore;
        }
        $comp->save();
        if ($comp) {
            request()
                ->session()
                ->flash('success', 'Company successfully Update');
        } else {
            request()
                ->session()
                ->flash('error', 'Error occurred while Update Company');
        }
        return redirect()->route('compaines.index');
    }

    public function destroy($id)
    {
        $delete = Compaines::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            request()
                ->session()
                ->flash('success', 'User Successfully deleted');
        } else {
            request()
                ->session()
                ->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('compaines.index');
    }
}
