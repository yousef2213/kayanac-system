<?php

namespace App\Http\Controllers;

use App\Bond;
use App\Branches;
use App\Compaines;
use App\CostCenters;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\Items;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\Purchases;
use App\PurchasesList;
use App\StoreModel;
use App\Supplier;
use App\Traits\GetAccounts;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyRestrictionsController extends Controller
{
    use GetAccounts;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $invoices = DailyRestrictions::all();
        $suppliers = Supplier::all();
        $branches = Branches::all();
        $invoices->each(function ($item) {
            $item->branshName = Branches::find($item->branshId)->namear;
        });

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsRestrictions" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsRestrictions" )->first();
        }
        return view('DailyRestrictions.index')
            ->with('branches', $branches)
            ->with('suppliers', $suppliers)
            ->with('orders', $orders)
            ->with('invoices', $invoices);
    }

    public function create()
    {
        $branches = Branches::all();
        $accounts = $this->accounts();
        $items = Items::all();
        $id = 1;
        $last = DailyRestrictions::all()->last();
        if ($last) {
            $id = $last->id + 1;
        }
        return view('DailyRestrictions.create')
            ->with('accounts', $accounts)
            ->with('items', $items)
            ->with('id', $id)
            ->with('branches', $branches);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'branshId' => 'required',
        ]);
        $debtor = 0;
        $creditor = 0;
        $list = json_decode($request->list[0], true);
        if (count($list) > 0) {
            foreach ($list as $item) {
                $deb = 0;
                $cer = 0;
                if (isset($item['debtor'])) {
                    $deb = $item['debtor'];
                }
                if (isset($item['creditor'])) {
                    $cer = $item['creditor'];
                }
                $debtor += $deb;
                $creditor += $cer;
            }
        }
        if ($debtor == $creditor) {

            $accounts = $this->accounts();
            $last = DailyRestrictions::all()->last();
            $new_id = 1;
            $newId = 1;
            if ($last) {
                $new_id = $last->num + 1;
            }
            if ($last) {
                $newId = $last->id + 1;
            }

            $fiscal = FiscalYears::all()->first();

            $invoice = DailyRestrictions::create([
                // 'date' => $request->date,
                'id' => $newId,
                'num' => $new_id,
                'manual' => 1,
                'fiscal_year' => $fiscal->code,
                'document' => $request->document,
                'description' => $request->description,
                'branshId' => $request->branshId,
                'creditor' => $creditor,
                'debtor' => $debtor,
            ]);
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $name = collect($accounts)->where('account_id', $item['account_id'])->first();

                    $deb = 0;
                    $cer = 0;
                    $dis = 0;
                    if (isset($item['debtor'])) {
                        $deb = $item['debtor'];
                    }
                    if (isset($item['creditor'])) {
                        $cer = $item['creditor'];
                    }
                    if (isset($item['description'])) {
                        $dis = $item['description'];
                    }
                    DailyRestrictionsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $item['account_id'],
                        'account_name' => $name->name,
                        'debtor' => $deb,
                        'creditor' => $cer,
                        'description' => $dis,
                    ]);
                }
            }
            return redirect()->route('daily.index')->with('success', "تم الاضافة بنجاح");
        } else {
            return redirect()->back()->with('faild', "مجموع المدين يجب ان يساوي مجموع الدائن");
        }
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $accounts = $this->accounts();
        $items = Items::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $invoice = DailyRestrictions::find($id);
        $invoices = DailyRestrictionsList::where('invoice_id', $id)->get();
        // return $invoices;
        return view('DailyRestrictions.edit')
            ->with('invoice', $invoice)
            ->with('invoices', $invoices)
            ->with('accounts', $accounts)
            ->with('stores', $stores)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {
        $debtor = 0;
        $creditor = 0;
        $list = json_decode($request->list[0], true);
        if (count($list) > 0) {
            foreach ($list as $item) {
                $deb = 0;
                $cer = 0;
                if (isset($item['debtor'])) {
                    $deb = $item['debtor'];
                }
                if (isset($item['creditor'])) {
                    $cer = $item['creditor'];
                }
                $debtor += $deb;
                $creditor += $cer;
            }
        }

        $invoice = DailyRestrictions::find($id);

        if ($debtor == $creditor) {
            $accounts = $this->accounts();

            if (count($list) > 0) {
                foreach ($list as $item) {
                    $deb = 0;
                    $cer = 0;
                    if (isset($item['debtor'])) {
                        $deb = $item['debtor'];
                    }
                    if (isset($item['creditor'])) {
                        $cer = $item['creditor'];
                    }
                    if ($item['isNew']) {
                        $name = collect($accounts)->where('account_id', $item['account_id'])->first();

                        $deb = 0;
                        $cer = 0;
                        $dis = 0;
                        if (isset($item['debtor'])) {
                            $deb = $item['debtor'];
                        }
                        if (isset($item['creditor'])) {
                            $cer = $item['creditor'];
                        }
                        if (isset($item['description'])) {
                            $dis = $item['description'];
                        }
                        DailyRestrictionsList::create([
                            'invoice_id' => $id,
                            'account_id' => $item['account_id'],
                            'account_name' => $name->name,
                            'debtor' => $deb,
                            'creditor' => $cer,
                            'description' => $dis,
                        ]);
                    } else {
                        $itemUpdate = DailyRestrictionsList::find($item['id']);

                        if ($item['account_id']) {
                            $itemUpdate->account_id = $item['account_id'];
                            $itemUpdate->save();
                        }
                        if ($item['account_name']) {
                            $itemUpdate->account_name = $item['account_name'];
                            $itemUpdate->save();
                        }
                        if ($item['debtor']) {
                            $itemUpdate->debtor = $item['debtor'];
                            $itemUpdate->save();
                        }
                        if ($item['creditor']) {
                            $itemUpdate->creditor = $item['creditor'];
                            $itemUpdate->save();
                        }
                        if ($item['description']) {
                            $itemUpdate->description = $item['description'];
                            $itemUpdate->save();
                        }
                    }
                }
            }
        } else {
            return redirect()->back()->with('faild', "مجموع المدين يجب ان يساوي مجموع الدائن");
        }

        $invoice->debtor = $debtor;
        $invoice->creditor = $creditor;
        if ($request->document) {
            $invoice->document = $request->document;
            $invoice->save();
        }
        if ($request->description) {
            $invoice->description = $request->description;
            $invoice->save();
        }
        $invoice->branshId = $request->branshId;
        $invoice->save();

        return redirect()->route('daily.index')->with('success', "تم تعديل القيد بنجاح");
    }


    public function deleteRow($id)
    {
        $saved = DailyRestrictionsList::find($id);
        $saved->delete();
        return response()->json([
            "status" => 200,
            'id' => $id
        ]);
    }

    public function destroy($id)
    {
        $invoice = DailyRestrictions::find($id);
        $purchaseList = DailyRestrictionsList::where('invoice_id', $id)->get();
        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {
                $purchaseItem->delete();
            }
        }
        if ($invoice) {
            $invoice->delete();
        }

        return redirect()->route('daily.index')->with('success', "تم الحذف بنجاح");
    }

    public function print($id)
    {
        $company = Compaines::find(1);
        $branch = Branches::find(1);
        $daily = DailyRestrictions::find($id);
        $list = DailyRestrictionsList::where("invoice_id", $id)->get();

        $list->each(function ($item) {
            if (isset($item->cost_center)) {
                $item->costName = CostCenters::find($item->cost_center)->namear;
            } else {
                $item->costName = '';
            }
        });

        if ($daily->source_name ==  "سند قبض نقدي" || $daily->source_name ==  "سند قبض بنكي" || $daily->source_name ==  "سند صرف نقدي" || $daily->source_name ==  "سند صرف بنكي") {
            $bond = Bond::find($daily->source);
            $daily->status = $bond->status;
        } else {
            $daily->status = 85;
        }
        // return   $daily;

        return view('DailyRestrictions.print')
            ->with('company', $company)
            ->with('branch', $branch)
            ->with('daily', $daily)
            ->with('list', $list);
    }
}
