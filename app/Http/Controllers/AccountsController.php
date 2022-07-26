<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\BalanceSheetGroup;
use App\Customers;
use App\Employees;
use App\OrderPages;
use App\Powers;
use App\StoreModel;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = Accounts::where('parent', '=', '1')->where('parentId', '=', '0')->get();
        $AllAccounts = Accounts::all();
        $customers = Customers::all();
        $employees = Employees::all();
        $suppliers = Supplier::all();
        $stores = StoreModel::all();
        $stores->each(function($item){
            $item->account_id = $item->id;
        });
        $AllAccounts->each(function ($ele) {
            if ($ele->parentId != 0) {
                $ele->parentIdName = Accounts::find($ele->parentId)->namear;
            } else {
                $ele->parentIdName = '';
            }

            if ($ele->parent_2_Id != 0) {
                $ele->parent_2_Id_Name = Accounts::find($ele->parent_2_Id)->namear;
            } else {
                $ele->parent_2_Id_Name = '';
            }
        });
        $newAccounts = $accounts->each(function ($account) {
            $account->ParentChild = Accounts::where('parentId', '=', $account->id)
                ->where('parent_2_Id', '=', 0)
                ->get();
        });
        $newAccounts->each(function ($account) {
            $account->ParentChild->each(function ($accountChild) {
                $accountChild->childList = Accounts::where('parent_2_Id', '=', $accountChild->id)
                    ->where('parent_3_Id', '=', '0')
                    ->get();
            });
        });
        $newAccounts->each(function ($account) {
            $account->ParentChild->each(function ($accountChild) {
                $accountChild->childList->each(function ($four) {
                    $four->FourList = Accounts::where('parent_3_Id', '=', $four->id)->where('parent_4_Id', '=', "0")->get();
                });
            });
        });
        $newAccounts->each(function ($account) {
            $account->ParentChild->each(function ($accountChild) {
                $accountChild->childList->each(function ($four) {
                    $four->FourList->each(function ($five) {
                        $five->FiveList = Accounts::where('parent_4_Id', '=', $five->id)->get();
                    });
                });
            });
        });


        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsAccountsGuide" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsAccountsGuide" )->first();
        }

        return view('Accounts.index')
            ->with('accounts', $accounts)
            ->with('customers', $customers)
            ->with('employees', $employees)
            ->with('orders', $orders)
            ->with('suppliers', $suppliers)
            ->with('stores', $stores)
            ->with('newAccounts', $newAccounts)
            ->with('AllAccounts', $AllAccounts);
    }

    public function edit($id)
    {
        $account = Accounts::find($id);
        return view('Accounts.edit')->with('account', $account);
    }
    public function update(Request $request, $id)
    {
        $account = Accounts::find($id);
        $account->namear = $request->namear;
        $account->nameen = $request->nameen;
        $account->balance_sheet = $request->balance_sheet;
        $account->save();
        if ($account) {
            return redirect()
                ->route('accounts.index')
                ->with('success', 'Added successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Failed to save successfully');
        }
    }
    public function getAccounts($id)
    {
        $accounts = Accounts::where('parentId', '=', $id)
            ->where('parent', '=', 1)
            ->where('parentId', '=', $id)
            ->where('parent_2_id', '=', 0)
            ->where('parent_3_id', '=', 0)
            ->where('parent_4_id', '=', 0)
            ->get();
        return $accounts;
    }

    public function getAccounts2($id, $parent)
    {
        $accounts = Accounts::where('parentId', '=', $id)
            ->where('parent', '=', 1)
            ->where('parentId', '=', $id)
            ->where('parent_2_id', '=', $parent)
            ->where('parent_3_id', '=', 0)
            ->where('parent_4_id', '=', 0)
            ->get();
        return $accounts;
    }

    public function getAccounts3($id, $parent, $child)
    {
        $accounts = Accounts::where('parentId', '=', $id)
            ->where('parent', '=', 1)
            ->where('parentId', '=', $id)
            ->where('parent_2_id', '=', $parent)
            ->where('parent_3_id', '=', $child)
            ->where('parent_4_id', '=', 0)
            ->get();
        return $accounts;
    }

    public function show($id)
    {
        $customers = Customers::all();
        return view('Accounts.show')->with('customers', $customers);
        return $id;
    }

    public function create()
    {
        $accounts = Accounts::where('parent', '=', '1')
            ->where('parent_2_Id', '=', '0')
            ->where('child', '=', '0')
            ->where('parentId', '=', '0')
            ->get();
        return view('Accounts.create')->with('accounts', $accounts);
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'namear' => 'required',
            'nameen' => 'required',
            'balance_sheet' => 'required|not_in:0',
        ]);
        if ($request->acount == 0 && $request->type == null) {
            return redirect()
                ->back()
                ->with('msg', 'من فضلك حدد حالة الحساب');
        }
        if ($request->type == null) {
            return redirect()
                ->back()
                ->with('msg', 'من فضلك حدد حالة الحساب');
        }
        $typeCheck = 0;
        $child = 0;
        if ($request->type == 2) {
            if ($request->acount == 0) {
                return redirect()
                    ->back()
                    ->with('msg', 'من فضلك اختر حساب');
            } else {
                $child = 1;
            }
        }
        if ($request->type == 1) {
            $typeCheck = 1;
        }
        if ($request->parent_3_id == 8 || $request->parent_3_id == 21) {
            return redirect()
                ->back()
                ->with('msg', 'لا يمكن الاضافة تحت هذا الحساب');
        }

        $account = Accounts::create([
            'namear' => $request->namear,
            'nameen' => $request->nameen,
            'balance_sheet' => $request->balance_sheet,
            'parent' => $typeCheck,
            'child' => $child,
            'parentId' => $request->acount,
            'parent_2_id' => $request->parent_2_id,
            'parent_3_id' => $request->parent_3_id,
            'parent_4_id' => $request->parent_4_id,
        ]);
        if ($account) {
            return redirect()
                ->route('accounts.index')
                ->with('success', 'Added successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Failed to save successfully');
        }
    }

    //  hash
    public function balanceSheetGroup()
    {
        return view('Accounts.balanceSheetGroup');
    }

    public function CreatebalanceSheet()
    {
        return view('Accounts.CreatebalanceSheet');
    }
    public function StorebalanceSheet(Request $request)
    {
        return $request;
        $group = BalanceSheetGroup::create([
            'namear' => $request->namear,
            'nameen' => $request->nameen,
        ]);
        if ($group) {
            return redirect()->back();
        }
    }


    public function AccountReports()
    {
        return view('Accounts.reports.index');
    }
}
