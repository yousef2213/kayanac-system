<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branches;
use App\Items;
use App\Itemslist;
use App\Bond;
use App\BondList;
use App\Compaines;
use App\CostCenters;
use App\Currencies;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\Employees;
use App\FiscalYears;
use App\OrderPages;
use App\Powers;
use App\StoreModel;
use App\Unit;
use App\Traits\GetAccounts;
use Illuminate\Support\Facades\Auth;

class BondController extends Controller
{
    use GetAccounts;

    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'سند قبض نقدي';
        $bonds = Bond::where('type', '1')->get();
        $bonds->each(function ($bond) {
            $count = 0;
            $bond->child = BondList::where('bond_id', $bond->id)->get();
            foreach ($bond->child as $item) {
                $count += $item->amount;
            }
            $bond->total = $count;
        });
        $type = 1;

        $orders = $this->getOrders("TsCashReceipt");
        return view('bond.index')
            ->with('bonds', $bonds)
            ->with('orders', $orders)
            ->with('type', $type)
            ->with('title', $title);
    }
    public function index2()
    {
        $title = 'سند قبض بنكي';
        $bonds = Bond::where('type', '2')->get();
        $bonds->each(function ($bond) {
            $count = 0;
            $bond->child = BondList::where('bond_id', $bond->id)->get();
            foreach ($bond->child as $item) {
                $count += $item->amount;
            }
            $bond->total = $count;
        });
        $type = 2;
        $orders = $this->getOrders("TsBankReceipt");

        return view('bond.index')
            ->with('bonds', $bonds)
            ->with('orders', $orders)
            ->with('type', $type)
            ->with('title', $title);
    }
    public function index3()
    {
        $title = 'سند صرف نقدي';
        $bonds = Bond::where('type', '3')->get();
        $bonds->each(function ($bond) {
            $count = 0;
            $bond->child = BondList::where('bond_id', $bond->id)->get();
            foreach ($bond->child as $item) {
                $count += $item->amount;
            }
            $bond->total = $count;
        });
        $type = 3;
        $orders = $this->getOrders("TsCashExChange");

        return view('bond.index')
            ->with('bonds', $bonds)
            ->with('type', $type)
            ->with('orders', $orders)
            ->with('title', $title);
    }

    public function index4()
    {
        $title = 'سند صرف بنكي';
        $bonds = Bond::where('type', '4')->get();
        $bonds->each(function ($bond) {
            $count = 0;
            $bond->child = BondList::where('bond_id', $bond->id)->get();
            foreach ($bond->child as $item) {
                $count += $item->amount;
            }
            $bond->total = $count;
        });
        $type = 4;
        $orders = $this->getOrders("TsBankExChange");
        return view('bond.index')
            ->with('bonds', $bonds)
            ->with('orders', $orders)
            ->with('type', $type)
            ->with('title', $title);
    }

    public function getOrders($Ts)
    {
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', $Ts )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', $Ts )->first();
        }
        return $orders;
    }

    public function create($type)
    {
        $branches = Branches::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $employees = Employees::where('occupation', '=', "مندوب")->get();
        $currencies = Currencies::all();
        $purchaseId = Bond::where('type', $type)->get()->last();
        $id = 1;
        if ($purchaseId) {
            $id = $purchaseId->num + 1;
        }
        $accounts = $this->accounts();
        return view('bond.create')
            ->with('accounts', $accounts)
            ->with('stores', $stores)
            ->with('currencies', $currencies)
            ->with('id', $id)
            ->with('type', $type)
            ->with('costCenters', $costCenters)
            ->with('employees', $employees)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function store(Request $request, $type)
    {
        $this->validate($request, [
            'status' => 'required',
            'account' => 'required',
        ]);

        $list = json_decode($request->list[0], true);
        $accounts = $this->accounts();
        $total = 0;
        $acc = collect($accounts)->where('account_id', $request->account)->first();
        $name = "";
        if ($type == 1) {
            $name = "سند قبض نقدي";
        }
        if ($type == 2) {
            $name = "سند قبض بنكي";
        }
        if ($type == 3) {
            $name = "سند صرف نقدي";
        }
        if ($type == 4) {
            $name = "سند صرف بنكي";
        }
        $lastBond = Bond::where('type', $type)->get()->last();
        if ($lastBond) {
            $newId = $lastBond->num + 1;
        } else {
            $newId = 1;
        }

        // return $type;
        // return $newId;
        if (count($list) > 0) {
            foreach ($list as $item) {
                if (!isset($item['account'])) {
                    return redirect()->back()->with('error', 'من فضلك تاكد من اختيار الحسابات');
                }
                $amount = 0;
                if (isset($item['amount'])) {
                    $amount = $item['amount'];
                }
                $total += $amount;
            }
        }
        if (count($list) == 0) {
            return redirect()->back()->with('error', 'من فضلك اكمل البيانات');
        }

        $fiscal_year = FiscalYears::find(1);
        $bond = Bond::create([
            'num' => $newId,
            'type' => $type,
            'fiscal_year' => $fiscal_year->code,
            'account_id' => $request->account,
            'account_name' => $accounts->where('account_id', $request->account)->first()->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);
        if ($request->date != "") {
            $bond->dateInvoice = $request->date;
            $bond->save();
        }

        if (count($list) > 0) {
            foreach ($list as $item) {
                $dis = "";
                if (isset($item['description'])) {
                    $dis = $item['description'];
                }
                $lastBondItem = BondList::all()->last();
                if ($lastBondItem) {
                    $newId = $lastBondItem->id + 1;
                } else {
                    $newId = 1;
                }
                $bondItem = BondList::create([
                    'id' => $newId,
                    'bond_id' => $bond->id,
                    'amount' => $item['amount'],
                    'account_id' => $item['account'],
                    'account_name' => $accounts->where('account_id', $request->account)->first()->name,
                    'description' => $dis,
                ]);
                if (isset($item['currency'])) {
                    $bondItem->currency = $item['currency'];
                    $bondItem->save();
                }
                if (isset($item['cost_center'])) {
                    $cost = CostCenters::find($item['cost_center']);
                    $bondItem->cost_center = $cost->id;
                    $bondItem->cost_center_name = $cost->namear;
                    $bondItem->save();
                }
                if (isset($item['delegate'])) {
                    $bondItem->delegate = $item['delegate'];
                    $bondItem->save();
                }
            }
        }
        // return $total;
        $totalDesc = "";
        if (isset($request->description)) {
            $totalDesc = $request->description;
        }
        $lastRe = DailyRestrictions::all()->last();
        $newIdR = 1;
        if ($lastRe) {
            $newIdR = $lastRe->id + 1;
        }
        $invoice = DailyRestrictions::create([
            'id' => $newIdR,
            'fiscal_year' => $fiscal_year->code,
            'document' => "",
            'description' => $totalDesc,
            'branshId' => 1,
            'source' => $bond->num,
            'source_name' => $name,
            'creditor' => $total,
            'debtor' => $total,
        ]);
        if ($request->date != "") {
            $invoice->dateInvoice = $request->date;
            $invoice->save();
        }
        if (count($list) > 0) {
            foreach ($list as $item) {
                $dis = "";
                if (isset($item['description'])) {
                    $dis = $item['description'];
                }
                $name = collect($accounts)->where('account_id', $item['account'])->first();
                if ($type == 3 || $type == 4) {
                    $dialy = DailyRestrictionsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $name->account_id,
                        'account_name' => $name->name,
                        'debtor' => $item['amount'],
                        'creditor' => 0,
                        'description' => $dis,
                    ]);
                } else {
                    $dialy = DailyRestrictionsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $name->account_id,
                        'account_name' => $name->name,
                        'debtor' => 0,
                        'creditor' => $item['amount'],
                        'description' => $dis,
                    ]);
                }

                if (isset($item['currency'])) {
                    $dialy->currency = $item['currency'];
                    $dialy->save();
                }
                if (isset($item['cost_center'])) {
                    $cost = CostCenters::find($item['cost_center']);
                    $dialy->cost_center = $cost->id;
                    $dialy->save();
                }
            }
        }

        if ($type == 3 || $type == 4) {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => 0,
                'creditor' => $total,
                'description' =>  $totalDesc,
            ]);
        } else {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => $total,
                'creditor' => 0,
                'description' =>  $totalDesc,
            ]);
        }






        if ($type == 1) {
            return redirect()
                ->route('bond.cash_receipt_voucher')
                ->with('msg', 'تم اضافة السند بنجاح');
        }
        if ($type == 2) {
            return redirect()
                ->route('bond.bank_receipt_voucher')
                ->with('msg', 'تم اضافة السند بنجاح');
        }
        if ($type == 3) {
            return redirect()
                ->route('bond.voucher_for_cash')
                ->with('msg', 'تم اضافة السند بنجاح');
        }
        if ($type == 4) {
            return redirect()
                ->route('bond.voucher_for_bank')
                ->with('msg', 'تم اضافة السند بنجاح');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id, $type)
    {
        $bond = Bond::find($id);
        $bondList = BondList::where('bond_id', $id)->get();
        $accounts = $this->accounts();
        $currencies = Currencies::all();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $employees = Employees::where('occupation', '=', "مندوب")->get();
        // return $bond;
        return view('bond.edit')
            ->with('bond', $bond)
            ->with('type', $type)
            ->with('employees', $employees)
            ->with('currencies', $currencies)
            ->with('bondList', $bondList)
            ->with('costCenters', $costCenters)
            ->with('accounts', $accounts);
    }



    public function update(Request $request, $id, $type) // *************
    {

        if ($type == 1) {
            $name = "سند قبض نقدي";
        }
        if ($type == 2) {
            $name = "سند قبض بنكي";
        }
        if ($type == 3) {
            $name = "سند صرف نقدي";
        }
        if ($type == 4) {
            $name = "سند صرف بنكي";
        }
        $list = json_decode($request->list[0], true);
        $newList = collect($list)->merge($request->listUpdate);
        $daily = DailyRestrictions::where('source_name', $name)->where('source', $id)->first();

        if ($daily) {
            $dailyList = DailyRestrictionsList::where('invoice_id', $daily->id)->get();
            $daily->delete();
            foreach ($dailyList as $dail) {
                $dail->delete();
            }
        }
        $total = 0;
        if (count($list) > 0) {
            foreach ($list as $item) {
                $amount = 0;
                if (isset($item['amount'])) {
                    $amount = $item['amount'];
                }
                $total += $amount;
            }
        }

        $bond = Bond::find($id);
        $accounts = $this->accounts();
        if ($request->listUpdate) {
            foreach ($request->listUpdate as  $item) {
                $itemUpdate = BondList::find($item['id']);
                if ($item['account_id']) {
                    $itemUpdate->account_id = $item['account_id'];
                    $acountEdit = $accounts->where("account_id", $item['account_id'])->first();
                    if (!isset($acountEdit)) {
                        $acountEdit =  $accounts->where("id", $item['account_id'])->first();
                    }
                    $itemUpdate->account_name = $acountEdit->name;
                    $itemUpdate->save();
                }

                if ($item['amount']) {
                    $itemUpdate->amount = $item['amount'];
                    $itemUpdate->save();
                }
                if ($item['cost_center'] == 'null') {
                    $itemUpdate->cost_center = 0;
                    $itemUpdate->cost_center_name = "";
                    $itemUpdate->save();
                }
                if ($item['cost_center'] && $item['cost_center'] != 'null') {
                    $cost = CostCenters::find($item['cost_center']);
                    $itemUpdate->cost_center = $item['cost_center'];
                    $itemUpdate->cost_center_name = $cost->namear;
                    $itemUpdate->save();
                }
                if ($item['delegate'] == 'null') {
                    $itemUpdate->delegate = 0;
                    $itemUpdate->save();
                }
                if ($item['currency']) {
                    $itemUpdate->currency = $item['currency'];
                    $itemUpdate->save();
                }
                if ($item['delegate'] && $item['delegate'] != 'null') {
                    $itemUpdate->delegate = $item['delegate'];
                    $itemUpdate->save();
                }
                if ($item['description']) {
                    $itemUpdate->description = $item['description'];
                    $itemUpdate->save();
                }
                $total += $itemUpdate['amount'];
            }
        }

        if (count($list) > 0) {
            foreach ($list as $item) {
                $des = '';
                if (isset($item['description'])) {
                    $des = $item['description'];
                }
                $acountEdit = $accounts->where("account_id", $item['account_id'])->first();
                if (!isset($acountEdit)) {
                    $acountEdit =  $accounts->where("id", $item['account_id'])->first();
                }
                $bondItem = BondList::create([
                    'bond_id' => $bond->id,
                    'amount' => $item['amount'],
                    'account_id' => $item['account_id'],
                    'account_name' => $acountEdit->name,
                    'description' => $des,
                ]);

                if (isset($item['currency'])) {
                    $bondItem->currency = $item['currency'];
                    $bondItem->save();
                }
                if (isset($item['cost_center']) && $item['cost_center'] != 'null') {
                    $cost = CostCenters::find($item['cost_center']);
                    $bondItem->cost_center = $cost->id;
                    $bondItem->cost_center_name = $cost->namear;
                    $bondItem->save();
                }
                if (isset($item['delegate'])) {
                    $bondItem->delegate = $item['delegate'];
                    $bondItem->save();
                }
            }
        }


        if ($request->date) {
            $bond->date = $request->date;
            $bond->save();
        }
        $bond->type = $type;
        $bond->account_id = $request->account_id;
        $bond->status = $request->status;
        $bond->description = $request->description;
        $bond->save();

        $this->createDailys($request, $bond, $total, $newList, $name, $type);
        if ($type == 1) {
            return redirect()
                ->route('bond.cash_receipt_voucher')
                ->with('msg', 'تم تعديل السند بنجاح');
        }
        if ($type == 2) {
            return redirect()
                ->route('bond.bank_receipt_voucher')
                ->with('msg', 'تم تعديل السند بنجاح');
        }
        if ($type == 3) {
            return redirect()
                ->route('bond.voucher_for_cash')
                ->with('msg', 'تم تعديل السند بنجاح');
        }
        if ($type == 4) {
            return redirect()
                ->route('bond.voucher_for_bank')
                ->with('msg', 'تم تعديل السند بنجاح');
        }
    }

    public function createDailys($request, $bond, $total, $list, $name, $type)
    {
        $accounts = $this->accounts();
        $acc = $accounts->where("account_id", $request->account_id)->first();
        if (!isset($acountEdit)) {
            $acc =  $accounts->where("id", $request->account_id)->first();
        }
        $totalDesc = "";
        if (isset($request->description)) {
            $totalDesc = $request->description;
        }
        $last = DailyRestrictions::all()->last();
        $new_id = 1;
        $newId = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }
        if ($last) {
            $newId = $last->id + 1;
        }
        $fiscal_year = FiscalYears::find(1);
        $invoice = DailyRestrictions::create([
            'fiscal_year' => $fiscal_year->code,
            'id' => $newId,
            'num' => $new_id,
            'document' => "",
            'description' => $totalDesc,
            'branshId' => 1,
            'source' => $bond->num,
            'source_name' => $name,
            'creditor' => $total,
            'debtor' => $total,
        ]);
        if ($request->date != "") {
            $invoice->dateInvoice = $request->date;
            $invoice->save();
        }
        if (count($list) > 0) {
            foreach ($list as $item) {
                $dis = "";
                if (isset($item['description'])) {
                    $dis = $item['description'];
                }

                $name = collect($accounts)->where('account_id', $item['account_id'])->first();
                if ($type == 3 || $type == 4) {
                    $daily = DailyRestrictionsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $name->account_id,
                        'account_name' => $name->name,
                        'debtor' => $item['amount'],
                        'creditor' => 0,
                        'description' => $dis,
                    ]);
                    if (isset($item['currency'])) {
                        $daily->currency = $item['currency'];
                        $daily->save();
                    }
                    if (isset($item['cost_center']) && $item['cost_center'] != 'null') {
                        $cost = CostCenters::find($item['cost_center']);
                        $daily->cost_center = $cost->id;
                        $daily->save();
                    }
                } else {
                    $daily = DailyRestrictionsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $name->account_id,
                        'account_name' => $name->name,
                        'debtor' => 0,
                        'creditor' => $item['amount'],
                        'description' => $dis,
                    ]);
                    if (isset($item['currency'])) {
                        $daily->currency = $item['currency'];
                        $daily->save();
                    }
                    if (isset($item['cost_center']) && $item['cost_center'] != 'null') {
                        $cost = CostCenters::find($item['cost_center']);
                        $daily->cost_center = $cost->id;
                        $daily->save();
                    }
                }
            }
        }

        if ($type == 3 || $type == 4) {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => 0,
                'creditor' => $total,
                'description' =>  $totalDesc,
            ]);
        } else {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => $total,
                'creditor' => 0,
                'description' =>  $totalDesc,
            ]);
        }
    }

    public function delete($id, $type)
    {
        $name = '';
        $bond = Bond::find($id);
        $bondList = BondList::where('bond_id', $id)->get();
        if ($bond->type == 1) {
            $name = "سند قبض نقدي";
        }
        if ($bond->type == 2) {
            $name = "سند قبض بنكي";
        }
        if ($bond->type == 3) {
            $name = "سند صرف نقدي";
        }
        if ($bond->type == 4) {
            $name = "سند صرف بنكي";
        }
        $ked = DailyRestrictions::where('source_name', $name)->where('source', $bond->num)->first();
        $kedItem = DailyRestrictionsList::where('invoice_id', $ked->id)->get();

        if (count($bondList) > 0) {
            foreach ($bondList as $purchaseItem) {
                $purchaseItem->delete();
            }
        }
        if (count($kedItem) > 0) {
            foreach ($kedItem as $item) {
                $item->delete();
            }
        }
        if ($bond) {
            $bond->delete();
            $ked->delete();
        }
        if ($type == 1) {
            return redirect()->route('bond.cash_receipt_voucher')->with('msg', "Deleted Success");
        }
        if ($type == 2) {
            return redirect()->route('bond.bank_receipt_voucher')->with('msg', "Deleted Success");
        }
        if ($type == 3) {
            return redirect()->route('bond.voucher_for_cash')->with('msg', "Deleted Success");
        }
        if ($type == 4) {
            return redirect()->route('bond.voucher_for_bank')->with('msg', "Deleted Success");
        }
    }




    public function print($id, $type)
    {
        $currency = Currencies::find(1);
        $company = Compaines::find(1);
        $branch = Branches::find(1);
        $bond = Bond::find($id);
        $list = BondList::where("bond_id", $id)->get();
        return view('bond.print')
            ->with('company', $company)
            ->with('currency', $currency)
            ->with('branch', $branch)
            ->with('type', $type)
            ->with('bond', $bond)
            ->with('item', $list[0]);
    }
}
