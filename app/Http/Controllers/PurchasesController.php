<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\Items;
use App\QtnItems;
use App\Itemslist;
use App\OpeningBalance;
use App\OpeningBalanceList;
use App\OrderPages;
use App\PermissionAdd;
use App\PermissionAddList;
use App\Powers;
use App\Purchases;
use App\PurchasesList;
use App\StoreModel;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsPurchases');
    }

    public function index()
    {
        $purchases = Purchases::all();
        $suppliers = Supplier::all();
        $branches = Branches::all();

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsInvoicePurchases" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsInvoicePurchases" )->first();
        }

        return view('Purchases.index')
            ->with('branches', $branches)
            ->with('suppliers', $suppliers)
            ->with('orders', $orders)
            ->with('purchases', $purchases);
    }

    public function create()
    {
        $company = Compaines::all()->first();
        $branches = Branches::all();
        $suppliers = Supplier::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchaseId = Purchases::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = Purchases::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }
        return view('Purchases.create')
            ->with('company', $company)
            ->with('suppliers', $suppliers)
            ->with('stores', $stores)
            ->with('id', $id)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function getUnits($id)
    {
        $list = Itemslist::where('itemId', $id)->get();
        $units = [];
        foreach ($list as $item) {
            $units[] = Unit::find($item->unitId);
        }
        return $units;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier' => 'required',
            'payment' => 'required',
            'branchId' => 'required',
        ]);
        // return $request->storeId;
        $netTotalList = 0;
        $taxs = 0;
        $totals = 0;
        $average_total = 0;

        $list = json_decode($request->list[0], true);
        $new_list = [];


        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemPurchase = PurchasesList::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->where('storeId', $item['storeId'])
                    ->get();

                $CalcCostFromBalance = OpeningBalanceList::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->get();
                $itemPurchase = collect($itemPurchase)->merge($CalcCostFromBalance);

                $totalP = 0; // اجمالي التكلفة
                $pids = [];
                // return $itemPurchase;
                foreach ($itemPurchase as $h) {
                    $pids[] = $h['total'];
                }
                $uniquePids = array_unique($pids);
                foreach ($uniquePids as $p) {
                    $totalP += $p;
                }
                $totalP += $item['qtn'] * $item['price'];

                $totalQ = 0; // اجمالي العدد
                $pidsQ = [];
                foreach ($itemPurchase as $h) {
                    $pidsQ[] = $h['qtn'];
                }
                $uniquePidsQ = array_unique($pidsQ);
                foreach ($uniquePidsQ as $p2) {
                    $totalQ += $p2;
                }
                $totalQ += $item['qtn'];


                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                if (!$itemCheck) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا توجد هذة الوحدة للصنف من فضلك قم باضافتها اولا');
                }

                $diss = 0;
                if (isset($item['discount'])) {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $netTotalList += $nettotal;
                $totals += $total;
                $taxs += $value;
                $item['av_price'] = $totalP / $totalQ;

                // $newPrices = 0;
                // $newQtns = 0;

                $itemAv = Itemslist::where('itemId', $item['itemId'])->get();
                $itemHere = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                $itemHere->av_price = $item['av_price'];
                $itemHere->save();

                foreach ($itemAv as $item_av) {
                    if ($item_av['small_unit'] == 1) {
                        $item_av->av_price = $item['price'] / $itemHere->packing;
                        $item_av->save();
                    }
                }
                $new_list[] = $item;
            }
        }
        $acc = Supplier::find($request->supplier);
        $fiscal_year = FiscalYears::all()->first();

        $idInoivePurcahe = 1;
        $lastIdId = Purchases::all()->last();
        if ($lastIdId) {
            $idInoivePurcahe = $lastIdId->id + 1;
        }
        $purchase = Purchases::create([
            "id" => $idInoivePurcahe,
            'fiscal_year' => $fiscal_year->code,
            'supplier' => $request->supplier,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
        ]);

        if ($request->supplier_invoice != "") {
            $purchase->supplier_invoice = $request->supplier_invoice;
            $purchase->save();
        }

        if ($request->taxSourceValue) {
            $purchase->netTotal = $netTotalList - $request->taxSourceValue;
            $purchase->save();
        }
        if ($request->taxSource) {
            $purchase->taxSource = $request->taxSource;
            $purchase->save();
        }

        $last = PermissionAdd::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }
        $permission = PermissionAdd::create([
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $purchase->id,
            'num' => $new_id,
            'source' => 'مشتريات',
            'customerId' => $request->supplier,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storeId' => $request->storeId,
        ]);
        if ($request->dateInvoice != "") {
            $purchase->dateInvoice = $request->dateInvoice;
            $permission->dateInvoice = $permission->dateInvoice;
            $permission->save();
            $purchase->save();
        }



        if (count($new_list) > 0) {
            foreach ($new_list as $item) {
                $average_total += $item['av_price'];
                $diss = 0;
                if (isset($item['discount'])) {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $addedN = '';

                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                PurchasesList::create([
                    'purchasesId' => $purchase->id,
                    'storeId' => $item['storeId'],
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'av_price' => $item['av_price'],
                    'discountRate' => $diss,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                    'storeId' => $permission->storeId
                ]);
                $this->saveQtn($item['itemId'], $item['unitId'], $item['storeId'], $item['qtn']);
                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $itemCheck->av_price = $totalP / $totalQ;
                $itemCheck->save();
                PermissionAddList::create([
                    'invoiceId' => $purchase->id,
                    'source_num' => $permission->id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'discountRate' => $diss,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                    'storeId' => $permission->storeId
                ]);
            }
        }

        $this->createCuff($request, $purchase, $netTotalList, $taxs, $acc, $average_total, $totals);

        return redirect()->route('ItemsPurchases.index');
    }

    public function show($id)
    {
        //
    }

    // Done
    public function saveQtn($item, $unit, $store, $qtn)
    {
        $status = Itemslist::where('itemId', $item)
            ->where('unitId', $unit)
            ->first();
        $check = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();
        if ($check) {
            $check->qtn = $check->qtn + $status->packing * $qtn;
            $check->save();
        } else {
            QtnItems::create([
                'item_id' => $item,
                'unit_id' => $unit,
                'store_id' => $store,
                'qtn' => $status->packing * $qtn,
            ]);
        }
    }

    // Create Cuff
    public function createCuff($request, $purchase, $netTotalList, $taxs, $acc, $average_total, $totals)
    {
        $fiscal_year = FiscalYears::find(1);
        // Cuff Account
        $last = DailyRestrictions::all()->last();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }

        $val  = 0;
        if ($request->taxSourceValue) {
            $val = $request->taxSourceValue;
        }

        $invoice = DailyRestrictions::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'document' => '',
            'description' => '',
            'branshId' => $request->branchId,
            'source' => $purchase->id,
            'source_name' => 'فاتورة مشتريات',
            'creditor' => $netTotalList,
            'debtor' => $netTotalList,
        ]);
        if ($request->payment == 1) {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => $netTotalList - $taxs,
                'creditor' => 0,
                'description' => '',
            ]);

            if ($request->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => 0,
                    'creditor' => $val,
                    'description' => '',
                ]);
            }

            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => $taxs,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }


            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => 0,
                'creditor' => $netTotalList - $val,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => 0,
                'creditor' => $netTotalList,
                'description' => '',
            ]);
        } else {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => $netTotalList - $taxs,
                'creditor' => 0,
                'description' => '',
            ]);

            if ($request->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => 0,
                    'creditor' => $val,
                    'description' => '',
                ]);
            }
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => $taxs,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }

            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => 0,
                'creditor' => $netTotalList - $val,
                'description' => '',
            ]);
        }
    }

    public function edit($id)
    {
        $company = Compaines::all()->first();
        $branches = Branches::all();
        $suppliers = Supplier::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchase = Purchases::find($id);
        $purchaseList = PurchasesList::where('purchasesId', $id)->get();
        $nettotal = 0;
        $taxValue = 0;
        foreach ($purchaseList as $item) {
            $nettotal = $item['total'];
            $taxValue = $item['value'];
        }
        return view('Purchases.edit')
            ->with('purchase', $purchase)
            ->with('purchaseList', $purchaseList)
            ->with('nettotal', $nettotal)
            ->with('taxValue', $taxValue)
            ->with('company', $company)
            ->with('suppliers', $suppliers)
            ->with('stores', $stores)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'supplier' => 'required',
            'payment' => 'required',
            'branchId' => 'required',
        ]);
        $netTotalList = 0;
        $taxs = 0;
        $totals = 0;
        $average_total = 0;

        $list = json_decode($request->list[0], true);
        $new_list = [];

        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemPurchase = PurchasesList::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->where('storeId', $item['storeId'])
                    ->get();
                $totalP = 0; // اجمالي التكلفة
                $pids = [];
                // return $itemPurchase;
                foreach ($itemPurchase as $h) {
                    $pids[] = $h['total'];
                }
                $uniquePids = array_unique($pids);
                foreach ($uniquePids as $p) {
                    $totalP += $p;
                }
                $totalP += $item['qtn'] * $item['price'];

                $totalQ = 0; // اجمالي العدد
                $pidsQ = [];
                foreach ($itemPurchase as $h) {
                    $pidsQ[] = $h['qtn'];
                }
                $uniquePidsQ = array_unique($pidsQ);
                foreach ($uniquePidsQ as $p2) {
                    $totalQ += $p2;
                }
                $totalQ += $item['qtn'];


                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                if (!$itemCheck) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا توجد هذة الوحدة للصنف من فضلك قم باضافتها اولا');
                }

                $diss = 0;
                if (isset($item['discount']) && $item['discount'] != '') {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $netTotalList += $nettotal;
                $totals += $total;
                $taxs += $value;
                $item['av_price'] = $totalP / $totalQ;

                // $newPrices = 0;
                // $newQtns = 0;

                $itemAv = Itemslist::where('itemId', $item['itemId'])->get();
                $itemHere = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                $itemHere->av_price = $item['av_price'];
                $itemHere->save();

                foreach ($itemAv as $item_av) {
                    if ($item_av['small_unit'] == 1) {
                        $item_av->av_price = $item['price'] / $itemHere->packing;
                        $item_av->save();
                    }
                }
                $new_list[] = $item;
            }
        }

        return $new_list;


        $acc = Supplier::find($request->supplier);
        $fiscal_year = FiscalYears::all()->first();

        $purchase = Purchases::find($id);

        if ($request->supplier_invoice != "") {
            $purchase->supplier_invoice = $request->supplier_invoice;
            $purchase->save();
        }

        if ($request->taxSourceValue) {
            $purchase->netTotal = $netTotalList - $request->taxSourceValue;
            $purchase->save();
        }
        if ($request->taxSource) {
            $purchase->taxSource = $request->taxSource;
            $purchase->save();
        }

        $permission =  PermissionAdd::where("source", 'مشتريات')->where("source_num", $id)->first();

        if ($request->dateInvoice != "") {
            $purchase->dateInvoice = $request->dateInvoice;
            $permission->dateInvoice = $permission->dateInvoice;
            $permission->save();
            $purchase->save();
        }



        if (count($new_list) > 0) {
            foreach ($new_list as $item) {
                $average_total += $item['av_price'];
                $diss = 0;
                if (isset($item['discount'])) {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $addedN = '';

                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                if ($item['isNew'] == true) {
                    PurchasesList::create([
                        'purchasesId' => $purchase->id,
                        'storeId' => $item['storeId'],
                        'itemId' => $item['itemId'],
                        'unitId' => $item['unitId'],
                        'qtn' => $item['qtn'],
                        'price' => $item['price'],
                        'av_price' => $item['av_price'],
                        'discountRate' => $diss,
                        'discountValue' => $discountValue,
                        'total' => $totalBefore,
                        'value' => $value,
                        'rate' => $addedN,
                        'nettotal' => $nettotal,
                    ]);
                }
                $this->saveQtn($item['itemId'], $item['unitId'], $item['storeId'], $item['qtn']);
                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $itemCheck->av_price = $totalP / $totalQ;
                $itemCheck->save();
                PermissionAddList::create([
                    'invoiceId' => $purchase->id,
                    'source_num' => $permission->id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'discountRate' => $diss,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                ]);
            }
        }



        // ++++
        $netTotalList = 0;
        $totalBeforCalculation = 0;
        $taxs = 0;
        if ($request->payment == '1') {
            $request->payment = 3;
        }
        $list = json_decode($request->list[0], true);


        $per = PermissionAdd::where("source", 'مشتريات')->where("source_num", $id)->first();
        $perList = PermissionAddList::where("source_num", $per->id)->get();
        $per->delete();
        foreach ($perList as $permision) {
            $permision->delete();
        }
        $last = PermissionAdd::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }

        $fiscal_year = FiscalYears::find(1);
        $purchase = Purchases::find($id);
        $permission = PermissionAdd::create([
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $id,
            'num' => $new_id,
            'source' => 'مشتريات',
            'customerId' => $request->supplier,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storeId' => 1,
        ]);

        $newList = collect($list)->merge($request->listUpdate);
        // return $newList;
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $itemPurchase = PurchasesList::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->where('storeId', $item['storeId'])
                    ->get();
                $totalP = 0; // اجمالي التكلفة
                $pids = [];
                // return $itemPurchase;
                foreach ($itemPurchase as $h) {
                    $pids[] = $h['total'];
                }
                $uniquePids = array_unique($pids);
                foreach ($uniquePids as $p) {
                    $totalP += $p;
                }
                $totalP = $item['price'] * $item['qtn'];
                // return $totalP / $totalQ;
                $totalQ = 0; // اجمالي العدد
                $pidsQ = [];
                foreach ($itemPurchase as $h) {
                    $pidsQ[] = $h['qtn'];
                }
                $uniquePidsQ = array_unique($pidsQ);
                foreach ($uniquePidsQ as $p2) {
                    $totalQ += $p2;
                }
                $totalQ = $item['qtn'];

                $itemHere = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                $itemHere->av_price = $totalP / $totalQ;
                $itemHere->save();
            }
        }
        // return "?done";

        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $diss = 0;
                if (isset($item['discount'])) {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $addedN = '';

                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                $totalBeforCalculation += $nettotal;


                PermissionAddList::create([
                    'invoiceId' => $purchase->id,
                    'source_num' => $permission->id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'discountRate' => $diss,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                ]);
            }
        }
        $permission->netTotal = $totalBeforCalculation;
        $permission->save();




        if (count($list) > 0) {
            foreach ($list as $item) {
                $di = 0;
                $ad = 0;
                if (isset($item['discount'])) {
                    $di = $item['discount'];
                }
                if (isset($item['added'])) {
                    $ad = $item['added'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($di * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $addedN = '';
                if (isset($ad)) {
                    $value = ($total * $ad) / 100;
                    $addedN = $ad;
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                PurchasesList::create([
                    'purchasesId' => $purchase->id,
                    'storeId' => $item['storeId'],
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'discountRate' => $di,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                ]);
                $netTotalList += $nettotal;
                $taxs += $value;
            }
        }
        if ($request->dateInvoice) {
            $purchase->dateInvoice = $request->dateInvoice;
            $purchase->save();
        }
        if ($request->supplier_invoice) {
            $purchase->supplier_invoice = $request->supplier_invoice;
            $purchase->save();
        }
        $purchase->supplier = $request->supplier;
        $purchase->payment = $request->payment;
        $purchase->branchId = $request->branchId;
        $purchase->save();

        if ($request->listUpdate) {
            foreach ($request->listUpdate as $item) {
                $itemUpdate = PurchasesList::find($item['id']);
                if ($item['storeId']) {
                    $itemUpdate->storeId = $item['storeId'];
                    $itemUpdate->save();
                }
                if ($item['itemId']) {
                    $itemUpdate->itemId = $item['itemId'];
                    $itemUpdate->save();
                }
                if ($item['unitId']) {
                    $itemUpdate->unitId = $item['unitId'];
                    $itemUpdate->save();
                }
                if ($item['qtn']) {
                    $itemUpdate->qtn = $item['qtn'];
                    $itemUpdate->save();
                }
                if ($item['price']) {
                    $itemUpdate->price = $item['price'];
                    $itemUpdate->save();
                }
                if ($item['discount']) {
                    $itemUpdate->discountRate = $item['discount'];
                    $itemUpdate->save();
                }
                if ($item['qtn'] && $item['price']) {
                    $diss = 0;
                    $add = 0;
                    if (isset($item['discount'])) {
                        $diss = $item['discount'];
                    }
                    if (isset($item['added'])) {
                        $add = $item['added'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($diss * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = ($total * $add) / 100;
                    $newTotal = $total + $value;
                    $itemUpdate->discountValue = $discountValue;
                    $itemUpdate->discountRate = $diss;

                    $itemUpdate->rate = $add;
                    $itemUpdate->total = $total;
                    $itemUpdate->value = $value;

                    $itemUpdate->nettotal = $newTotal;
                    $netTotalList += $newTotal;
                    $taxs += $value;
                    $itemUpdate->save();
                }
            }
        }


        $cuu =  DailyRestrictions::where('source_name', 'فاتورة مشتريات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();


        $cuu->debtor = $totalBeforCalculation - $request->taxSourceValue;
        $cuu->creditor = $totalBeforCalculation - $request->taxSourceValue;
        $cuu->save();
        if (count($cuuList) > 0) {
            foreach ($cuuList as $cuuItem) {
                $cuuItem->delete();
            }
        }

        if ($request->payment == 1 || $request->payment == 3) {
            $cuuList[0]->debtor = $netTotalList - $taxs;
            $cuuList[0]->save();
            if ($taxs != 0) {
                $cuuList[1]->debtor = $taxs;
                $cuuList[1]->save();

                $cuuList[2]->creditor = $netTotalList;
                $cuuList[2]->save();

                $cuuList[3]->debtor = $netTotalList;
                $cuuList[3]->save();

                $cuuList[4]->creditor = $netTotalList;
                $cuuList[4]->save();
            } else {
                $cuuList[1]->creditor = $netTotalList;
                $cuuList[1]->save();

                $cuuList[2]->creditor = $netTotalList;
                $cuuList[2]->save();

                $cuuList[3]->debtor = $netTotalList;
                $cuuList[3]->save();
            }
        } else {
            $cuuList[0]->debtor = $netTotalList - $taxs;
            $cuuList[0]->save();
            if ($taxs != 0) {
                $cuuList[1]->debtor = $taxs;
                $cuuList[1]->save();

                $cuuList[2]->creditor = $netTotalList;
                $cuuList[2]->save();
            } else {
                $cuuList[1]->creditor = $netTotalList;
                $cuuList[1]->save();
            }
        }
        $cuu->debtor = $netTotalList;
        $cuu->creditor = $netTotalList;
        $cuu->save();


        return redirect()->route('ItemsPurchases.index');
    }




    public function destroy($id)
    {
        $per = PermissionAdd::where("source", 'مشتريات')->where("source_num", $id)->first();
        $perList = PermissionAddList::where("source_num", $per->id)->get();
        $purchase = Purchases::find($id);
        $purchaseList = PurchasesList::where('purchasesId', $id)->get();
        $cuu =  DailyRestrictions::where('source_name', 'فاتورة مشتريات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();


        // Check Invoice
        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {
                $status = Itemslist::where('itemId', $purchaseItem['itemId'])->where('unitId', $purchaseItem['unitId'])->first();
                $check = QtnItems::where('item_id', $purchaseItem['itemId'])->where('store_id', $purchaseItem['storeId'])->first();
                if ($check) {
                    $newQ = ($purchaseItem['qtn'] * $status->packing);
                    if ($newQ > $check->qtn) {
                        return redirect()->back()->with('msg', 'لقد تمت حركات علي هذة الفاتورة لا يمكن حذفها');
                    }
                    $check->qtn = $check->qtn - ($status->packing * $purchaseItem['qtn']);
                    $check->save();
                }
            }
        }




        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {

                // $itemPurchase = PurchasesList::where('itemId', $purchaseItem['itemId'])
                //     ->where('unitId', $purchaseItem['unitId'])
                //     ->where('storeId', $purchaseItem['storeId'])
                //     ->get();

                // $CalcCostFromBalance = OpeningBalanceList::where('itemId', $purchaseItem['itemId'])
                //     ->where('unitId', $purchaseItem['unitId'])
                //     ->get();
                // $itemPurchase = collect($itemPurchase)->merge($CalcCostFromBalance);
                // return $itemPurchase;
                // $totalP = 0; // اجمالي التكلفة
                // $pids = [];
                // // return $itemPurchase;
                // foreach ($itemPurchase as $h) {
                //     $pids[] = $h['total'];
                // }
                // $uniquePids = array_unique($pids);
                // foreach ($uniquePids as $p) {
                //     $totalP += $p;
                // }
                // $totalP += $purchaseItem['qtn'] * $purchaseItem['price'];

                // $totalQ = 0; // اجمالي العدد
                // $pidsQ = [];
                // foreach ($itemPurchase as $h) {
                //     $pidsQ[] = $h['qtn'];
                // }
                // $uniquePidsQ = array_unique($pidsQ);
                // foreach ($uniquePidsQ as $p2) {
                //     $totalQ += $p2;
                // }
                // $totalQ += $purchaseItem['qtn'];


                // $itemCheck = Itemslist::where('itemId', $purchaseItem['itemId'])
                //     ->where('unitId', $purchaseItem['unitId'])
                //     ->first();

                // if (!$itemCheck) {
                //     return redirect()
                //         ->back()
                //         ->with('error', 'لا توجد هذة الوحدة للصنف من فضلك قم باضافتها اولا');
                // }




                // $itemPurchase['av_price'] = $totalP / $totalQ;

                // // $newPrices = 0;
                // // $newQtns = 0;

                // $itemAv = Itemslist::where('itemId', $itemPurchase['itemId'])->get();
                // $itemHere = Itemslist::where('itemId', $itemPurchase['itemId'])->where('unitId', $itemPurchase['unitId'])->first();
                // $itemHere->av_price = $itemPurchase['av_price'];
                // $itemHere->save();




                $purchaseItem->delete();
            }
        }



        if (count($cuuList) > 0) {
            foreach ($cuuList as $cuuItem) {
                $cuuItem->delete();
            }
            foreach ($perList as $permision) {
                $permision->delete();
            }
        }

        if ($purchase && $cuu) {
            $purchase->delete();
            $cuu->delete();
            $per->delete();
        }
        return redirect()->route('ItemsPurchases.index')->with('msg', "Deleted Successfully");
    }
}
