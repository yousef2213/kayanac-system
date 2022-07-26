<?php

namespace App\Http\Controllers;

use App\Branches;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\Items;
use App\PermissionCashing;
use App\QtnItems;
use App\PermissionCashingList;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\ReturnedInvoice;
use App\ReturnedInvoiceList;
use App\StoreModel;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnedInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $purchases = ReturnedInvoice::all();
        $suppliers = Supplier::all();
        $branches = Branches::all();

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsReturnedPurchases" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsReturnedPurchases" )->first();
        }
        return view('ReturnedInvoice.index')
            ->with('branches', $branches)
            ->with('suppliers', $suppliers)
            ->with('orders', $orders)
            ->with('purchases', $purchases);
    }

    public function create()
    {
        $branches = Branches::all();
        $suppliers = Supplier::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchaseId = ReturnedInvoice::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = ReturnedInvoice::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }
        return view('ReturnedInvoice.create')
            ->with('suppliers', $suppliers)
            ->with('stores', $stores)
            ->with('id', $id)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier' => 'required',
            'payment' => 'required',
            'branchId' => 'required',
        ]);
        $netTotalList = 0;
        $taxs = 0;
        if ($request->payment == '1') {
            $request->payment = 3;
        }
        $list = json_decode($request->list[0], true);
        $acc = Supplier::find($request->supplier);
        $netTotalList = 0;
        $taxs = 0;
        if (count($list) > 0) {
            foreach ($list as $item) {
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
                $taxs += $value;
                $balance = $this->getBalance($item['itemId'], $item['unitId'], $item['storeId'], $item['qtn']);
                if ($balance == 0) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا يوجد هذا الصنف في المخزن');
                } elseif ($balance < $item['qtn']) {
                    return redirect()
                        ->back()
                        ->with('error', 'مخزون صنف ' . Items::find($item['itemId'])->namear . ' غير كافي');
                }
            }
        }
        $newList = [];

        if (count($list) > 0) {
            foreach ($list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $newList[] = $item;
            }
        }
        // return $newList;
        $fiscal_year = FiscalYears::find(1);

        $purchase = ReturnedInvoice::create([
            'fiscal_year' => $fiscal_year->code,
            'supplier' => $request->supplier,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
        ]);

        if ($request->dateInvoice != "") {
            $purchase->dateInvoice = $request->dateInvoice;
            $purchase->save();
        }
        if ($request->supplier_invoice != "") {
            $purchase->supplier_invoice = $request->supplier_invoice;
            $purchase->save();
        }

        $last = PermissionCashing::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }
        $permission = PermissionCashing::create([
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $purchase->id,
            'num' => $new_id,
            'source' => 'مرتجع مشتريات',
            'customerId' => $request->supplier,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storeId' => 1,
        ]);
        // Cuff Account
        $lastRee = DailyRestrictions::all()->last();
        $id = 1;
        if ($lastRee) {
            $id = $last->id + 1;
        }
        $invoice = DailyRestrictions::create([
            'id' => $id,
            'document' => '',
            'fiscal_year' => $fiscal_year->code,
            'description' => '',
            'branshId' => $request->branchId,
            'source' => $purchase->id,
            'source_name' => 'مرتجع مشتريات',
            'creditor' => $netTotalList,
            'debtor' => $netTotalList,
        ]);
        if ($request->dateInvoice != "") {
            $permission->dateInvoice = $request->dateInvoice;
            $invoice->date = $request->dateInvoice;
            $permission->save();
            $invoice->save();
        }
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $diss = 0;
                if (isset($item['discount']) && $item['discount'] != '') {
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

                ReturnedInvoiceList::create([
                    'purchasesId' => $purchase->id,
                    'storeId' => $item['storeId'],
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
                PermissionCashingList::create([
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
                $qtnN = QtnItems::where('item_id', $item['itemId'])
                    ->where('store_id', $item['storeId'])
                    ->first();
                $qtnN->qtn = $qtnN->qtn - $item['newQ'];
                $qtnN->save();
            }
        }

        // Caff
        if ($request->payment == 1 || $request->payment == 3) {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }

            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => 0,
                'creditor' => $netTotalList - $taxs,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);

            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => 0,
                'creditor' => $netTotalList,
                'description' => '',
            ]);
        } else {
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => $acc->account_id,
                'account_name' => $acc->name,
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $invoice->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }
            DailyRestrictionsList::create([
                'invoice_id' => $invoice->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => 0,
                'creditor' => $netTotalList - $taxs,
                'description' => '',
            ]);
        }
        return redirect()->route('returnedInvoices.index');
    }

    public function getBalance($item, $unit, $store, $qtn)
    {
        $check = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();
        if ($check) {
            return $check->qtn;
        } else {
            return 0;
        }
    }
    public function changeQtn($item, $unit, $store, $qtn)
    {
        $check = QtnItems::where('item_id', $item)
            ->where('unit_id', $unit)
            ->where('store_id', $store)
            ->first();
        if ($check) {
            $check->qtn = $check->qtn - $qtn;
            $check->save();
        }
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $suppliers = Supplier::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchase = ReturnedInvoice::find($id);
        $purchaseList = ReturnedInvoiceList::where('purchasesId', $id)->get();
        return view('ReturnedInvoice.edit')
            ->with('purchase', $purchase)
            ->with('purchaseList', $purchaseList)
            ->with('suppliers', $suppliers)
            ->with('stores', $stores)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {
        $netTotalList = 0;
        $taxs = 0;
        $acc = Supplier::find($request->supplier);
        $list = json_decode($request->list[0], true);
        $purchase = ReturnedInvoice::find($id);
        $per = PermissionCashing::where("source", 'مرتجع مشتريات')->where("source_num", $id)->first();
        $perList = PermissionCashingList::where("source_num", $per->id)->get();
        $newList = collect($list)->merge($request->listUpdate);
        if (count($list) > 0) {
            foreach ($list as $item) {
                $balance = $this->getBalance($item['itemId'], $item['unitId'], $item['storeId'], $item['qtn']);
                if ($balance == 0) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا يوجد هذا الصنف في المخزن');
                } elseif ($balance < $item['qtn']) {
                    return redirect()
                        ->back()
                        ->with('error', 'مخزون صنف ' . Items::find($item['itemId'])->namear . ' غير كافي');
                }
            }
        }
        $per->delete();
        foreach ($perList as $permision) {
            $permision->delete();
        }
        $fiscal_year = FiscalYears::find(1);
        $last = PermissionCashing::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }
        if (!empty($list)) {
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $dis = 0;
                    if (isset($item['discount'])) {
                        $dis = $item['discount'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($dis * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $addedN = 0;
                    if (isset($item['added'])) {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $netTotalList += $nettotal;
                    $taxs += $value;
                }
            }
        }
        $permission = PermissionCashing::create([
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $purchase->id,
            'num' => $new_id,
            'source' => 'مرتجع مشتريات',
            'customerId' => $request->supplier,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storeId' => 1,
        ]);
        $i = 0;

        if (!empty($list)) {
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $dis = 0;
                    if (isset($item['discount'])) {
                        $dis = $item['discount'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($dis * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $addedN = 0;
                    if (isset($item['added'])) {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    ReturnedInvoiceList::create([
                        'purchasesId' => $purchase->id,
                        'storeId' => $item['storeId'],
                        'itemId' => $item['itemId'],
                        'unitId' => $item['unitId'],
                        'qtn' => $item['qtn'],
                        'price' => $item['price'],
                        'discountRate' => $dis,
                        'discountValue' => $discountValue,
                        'total' => $totalBefore,
                        'value' => $value,
                        'rate' => $addedN,
                        'nettotal' => $nettotal,
                    ]);
                }
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
                $itemUpdate = ReturnedInvoiceList::find($item['id']);
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
                    $status = Itemslist::where('itemId', $itemUpdate->itemId)->where('unitId', $itemUpdate->unitId)->first();
                    $check = QtnItems::where('item_id', $item['itemId'])
                        ->where('store_id', $itemUpdate['storeId'])
                        ->first();
                    if ($item['qtn'] < $itemUpdate->qtn) {
                        $between = $itemUpdate->qtn - $item['qtn'];
                        $newQtn = $between * $status->packing;
                        $check->qtn = $check->qtn + $newQtn;
                        $check->save();
                    }
                    if ($item['qtn'] > $itemUpdate->qtn) {
                        $between = $item['qtn'] - $itemUpdate->qtn;
                        $newQtn = $between * $status->packing;
                        $check->qtn = $check->qtn - $newQtn;
                        $check->save();
                    }

                    // $betwen = $check->qtn - $status->packing * $item['qtn'];
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
                    $discou = 0;
                    $addu = 0;
                    if (isset($item['discount'])) {
                        $discou = $item['discount'];
                    }
                    if (isset($item['added'])) {
                        $addu = $item['added'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($discou * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = ($total * $addu) / 100;
                    $nettotal = $total + $value;
                    $itemUpdate->discountValue = $discountValue;
                    $itemUpdate->discountRate = $discou;

                    $itemUpdate->rate = $addu;
                    $itemUpdate->value = $value;

                    $itemUpdate->nettotal = $nettotal;
                    $netTotalList += $nettotal;
                    $taxs += $value;

                    // $perList[$i]->nettotal = $nettotal;
                    // $perList[$i]->rate = $addu;
                    // $perList[$i]->total = $total;
                    // $perList[$i]->discountValue = $discountValue;
                    // $perList[$i]->save();

                    $i += 1;
                    $itemUpdate->save();
                }
            }
        }
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $dis = 0;
                if (isset($item['discount'])) {
                    $dis = $item['discount'];
                }

                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($dis * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $addedN = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                PermissionCashingList::create([
                    'invoiceId' => $purchase->id,
                    'source_num' => $permission->id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                    'price' => $item['price'],
                    'discountRate' => $dis,
                    'discountValue' => $discountValue,
                    'total' => $totalBefore,
                    'value' => $value,
                    'rate' => $addedN,
                    'nettotal' => $nettotal,
                ]);
            }
        }

        // Cuff Done
        $cuu =  DailyRestrictions::where('source_name', 'مرتجع مشتريات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();
        $cuu->branshId = $request->branchId;
        $cuu->creditor = $netTotalList;
        $cuu->debtor = $netTotalList;
        $cuu->save();


        if ($request->payment == 1 || $request->payment == 3) {
            $cuuList[0]->account_id = $acc->account_id;
            $cuuList[0]->account_name = $acc->name;
            $cuuList[0]->debtor = $netTotalList;
            $cuuList[0]->save();
            if ($taxs != 0) {
                $cuuList[1]->creditor = $taxs;
                $cuuList[1]->save();
            } else {
                $cuuList[1]->creditor = $netTotalList - $taxs;
                $cuuList[1]->save();
            }
            $cuuList[2]->debtor = $netTotalList;
            $cuuList[2]->save();

            $cuuList[3]->account_id = $acc->account_id;
            $cuuList[3]->account_name = $acc->name;
            $cuuList[3]->creditor = $netTotalList;
            $cuuList[3]->save();
        } else {
            $cuuList[0]->account_id = $acc->account_id;
            $cuuList[0]->account_name = $acc->name;
            $cuuList[0]->debtor = $netTotalList;
            $cuuList[0]->save();

            if ($taxs != 0) {
                $cuuList[1]->creditor = $taxs;
                $cuuList[1]->save();
            } else {
                $cuuList[1]->creditor = $netTotalList - $taxs;
                $cuuList[1]->save();
            }
        }
        return redirect()->route('returnedInvoices.index');
    }



    public function destroy($id)
    {
        $per = PermissionCashing::where("source", 'مرتجع مشتريات')->where("source_num", $id)->first();
        $perList = PermissionCashingList::where("source_num", $per->id)->get();

        $purchase = ReturnedInvoice::find($id);
        $purchaseList = ReturnedInvoiceList::where('purchasesId', $id)->get();
        $cuu =  DailyRestrictions::where('source_name', 'مرتجع مشتريات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();
        foreach ($purchaseList as $invoice) {
            $status = Itemslist::where('itemId', $invoice['itemId'])->where('unitId', $invoice['unitId'])->first();
            $check = QtnItems::where('item_id',  $invoice['itemId'])->where('store_id',  $invoice['storeId'])->first();

            if ($check) {
                $check->qtn = $check->qtn + ($status->packing * $invoice['qtn']);
                $check->save();
            }
        }

        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {
                $purchaseItem->delete();
            }
            foreach ($perList as $perItem) {
                $perItem->delete();
            }
            foreach ($cuuList as $cu) {
                $cu->delete();
            }
        }
        if ($purchase) {
            $purchase->delete();
            $cuu->delete();
            $per->delete();
        }
        return redirect()->route('returnedInvoices.index')->with("msg", "Deleted Successfully");
    }
}
