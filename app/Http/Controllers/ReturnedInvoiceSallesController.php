<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\QtnItems;
use App\Items;
use App\Itemslist;
use App\OrderPages;
use App\PermissionAdd;
use App\PermissionAddList;
use App\Powers;
use App\ReturnedSallesInvoice;
use App\ReturnedSallesInvoiceList;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnedInvoiceSallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsReturnedSales');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $savedSalles = ReturnedSallesInvoiceList::all();
        $Invoices = ReturnedSallesInvoice::all();
        $customers = Customers::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsReturnedSales" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsReturnedSales" )->first();
        }
        return view('SalesBillReturned.index')
            ->with('Invoices', $Invoices)
            ->with('orders', $orders)
            ->with('savedSalles', $savedSalles)
            ->with('customers', $customers);
    }

    public function create()
    {
        $branches = Branches::all();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchaseId = ReturnedSallesInvoice::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = ReturnedSallesInvoice::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }

        return view('SalesBillReturned.create')
            ->with('customer', $customers)
            ->with('stores', $stores)
            ->with('id', $id)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function store(Request $request)
    {
        $list = json_decode($request->list[0], true);
        $netTotalList = 0;
        $average_total = 0;
        $taxs = 0;
        if ($request->payment == '1') {
            $request->payment = 3;
        }
        $fiscal_year = FiscalYears::all()->first();
        $last = PermissionAdd::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }

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
            }
        }
        $acc = Customers::find($request->customerId);

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
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $average_total += $item['av_price'];

                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $check = $this->getQtn($item['itemId'], $item['unitId'], $item['storeId']);
                    if ($check) {
                        if ($check->qtn < $item['newQ']) {
                            return response()->json([
                                'msg' => 'لا يوجد رصيد للصنف',
                                'status' => 201,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'msg' => 'لا يوجد رصيد للصنف',
                            'status' => 201,
                        ]);
                    }
                }
            }
        }
        $invoice = ReturnedSallesInvoice::create([
            'fiscal_year' => $fiscal_year->code,
            'branchId' => $request->branchId,
            'status' => $request->payment,
            'netTotal' => $netTotalList,
            'customerId' => $request->customerId,
        ]);

        $permission = PermissionAdd::create([
            'source_num' => $invoice->id,
            'fiscal_year' => $fiscal_year->code,
            'source' => 'مرتجع مبيعات',
            'num' => $new_id,
            'customerId' => $request->customerId,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storedId' => 1,
        ]);

        if ($request->dateInvoice != "") {
            $permission->dateInvoice = $request->dateInvoice;
            $permission->save();
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
                $value = 0;
                $addedN = '';
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                $itemDetails = Items::find($item['itemId']);
                ReturnedSallesInvoiceList::create([
                    'invoiceId' => $invoice->id,
                    'catId' => $itemDetails->catId, // --
                    'groupItem' => $itemDetails->catId, // --
                    'storeId' => $item['storeId'],
                    'itemId' => $item['itemId'], // --
                    'unitId' => $item['unitId'], // --
                    'qtn' => $item['qtn'], // --
                    'price' => $item['price'], // --
                    'discountRate' => $diss, // --
                    'discountValue' => $discountValue, // --
                    'price' => $item['price'], // --
                    'nettotal' => $nettotal, // --
                    'rate' => $addedN, // --
                    'total' => $totalBefore, // --
                    'value' => $value,
                    'priceWithTax' => $itemDetails->priceWithTax, // --
                ]);
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);

                if ($MainItem->item_type != 3) {
                    PermissionAddList::create([
                        'invoiceId' => $invoice->id,
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
                    $qtnN->qtn = $qtnN->qtn + $item['newQ'];
                    $qtnN->save();
                }
            }
        }


        $perList = PermissionAddList::where("source_num", $permission->id)->get();
        if (count($perList) <= 0) {
            $permission->delete();
        }

        $this->createCuff($request, $acc, $netTotalList, $invoice, $taxs, $average_total);

        return redirect()->route('SallesReturned.returned');
    }


    // انشاء القيود
    public function createCuff($data, $account, $netTotalList = 0, $invoice, $taxs, $average_total)
    {
        // Cuff Account
        $last = DailyRestrictions::all()->last();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }
        $idIn = DailyRestrictions::create([
            'id' => $id,
            'document' => '',
            'description' => '',
            'branshId' => $data->branchId,
            'source' => $invoice->id,
            'source_name' => 'مرتجع مبيعات',
            'creditor' => $netTotalList,
            'debtor' => $netTotalList,
        ]);


        if ($data->payment == 1 || $data->payment == 3) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $netTotalList,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 36,
                'account_name' => 'مرتجع المبيعات',
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
            if ($average_total != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 27,
                    'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                    'debtor' => 0,
                    'creditor' => $average_total,
                    'description' => '',
                ]);
            }

            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);

            //
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => 0,
                'creditor' => $netTotalList,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
        } else {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $netTotalList,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 36,
                'account_name' => 'مرتجع المبيعات',
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 27,
                'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                'debtor' => 0,
                'creditor' => $average_total,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 12,
                'account_name' => 'مخزون المخزن الرئيسى',
                'debtor' => $netTotalList,
                'creditor' => 0,
                'description' => '',
            ]);
        }
        return $idIn;
    }


    public function getQtn($item = 1, $unit = 1, $store)
    {
        $qtn = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();

        return $qtn;
    }
    public function edit($id)
    {
        $branches = Branches::all();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $invocie = ReturnedSallesInvoice::find($id);
        // return $invocie;
        $invoiceList = ReturnedSallesInvoiceList::where('invoiceId', $id)->get();
        // return $invoiceList;
        return view('SalesBillReturned.edit')
            ->with('invocie', $invocie)
            ->with('invoiceList', $invoiceList)
            ->with('customers', $customers)
            ->with('stores', $stores)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {
        $list = json_decode($request->list[0], true);
        if ($request->payment == '1') {
            $request->payment = 3;
        }

        $invoice = ReturnedSallesInvoice::find($id);
        if (!empty($list)) {
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($item['discount'] * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = 0;
                    $addedN = '';
                    if (isset($item['added'])) {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $itemDetails = Items::find($item['itemId']);
                    ReturnedSallesInvoiceList::create([
                        'invoiceId' => $invoice->id,
                        'catId' => $itemDetails->catId, // --
                        'groupItem' => $itemDetails->catId, // --
                        'storeId' => $item['storeId'],
                        'itemId' => $item['itemId'], // --
                        'unitId' => $item['unitId'], // --
                        'qtn' => $item['qtn'], // --
                        'price' => $item['price'], // --
                        'discountRate' => $item['discount'], // --
                        'discountValue' => $discountValue, // --
                        'price' => $item['price'], // --
                        'namear' => $itemDetails->catId, // --
                        'nameen' => $itemDetails->catId, // --
                        'netTotal' => $nettotal, // --
                        'rate' => $addedN, // --
                        'total' => $totalBefore, // --
                        'value' => $value,
                        'priceWithTax' => $itemDetails->priceWithTax, // --
                    ]);
                }
            }
        }

        $invoice->customerId = $request->customerId;
        $invoice->branchId = $request->branchId;
        $invoice->save();

        if ($request->listUpdate) {
            foreach ($request->listUpdate as $item) {
                $itemUpdate = ReturnedSallesInvoiceList::find($item['id']);
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
                if ($item['discount'] && $item['qtn'] && $item['price'] && $item['added']) {
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($item['discount'] * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = ($total * $item['added']) / 100;
                    $nettotal = $total + $value;
                    $itemUpdate->discountValue = $discountValue;
                    $itemUpdate->discountRate = $item['discount'];

                    $itemUpdate->rate = $item['added'];
                    $itemUpdate->value = $value;

                    $itemUpdate->netTotal = $nettotal;
                    $itemUpdate->save();
                }
            }
        }

        $lastTotal = 0;
        if (count($list) > 0) {
            foreach ($list as $item) {
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($item['discount'] * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $lastTotal += $nettotal;
            }
        }
        if ($request->listUpdate) {
            foreach ($request->listUpdate as $item) {
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($item['discount'] * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $lastTotal += $nettotal;
            }
        }
        $invoice->netTotal = $lastTotal;
        $invoice->save();
        return redirect()->route('SallesReturned.returned');
    }

    public function destroy($id)
    {
        $per = PermissionAdd::where("source", 'مرتجع مبيعات')->where("source_num", $id)->first();
        $perList = PermissionAddList::where("source_num", $per->id)->get();

        $cuu =  DailyRestrictions::where('source_name', 'مرتجع مبيعات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();
        $delete = ReturnedSallesInvoice::findorFail($id);
        $saved = ReturnedSallesInvoiceList::where('invoiceId', $id)->get();
        foreach ($saved as $invoice) {
            $status = Itemslist::where('itemId', $invoice['itemId'])->where('unitId', $invoice['unitId'])->first();
            $check = QtnItems::where('item_id',  $invoice['itemId'])->where('store_id',  $invoice['storeId'])->first();
            if ($check) {
                $check->qtn = $check->qtn - ($status->packing * $invoice['qtn']);
                $check->save();
            }
        }
        foreach ($saved as $invoice) {
            $invoice->delete();
        }
        foreach ($perList as $perItem) {
            $perItem->delete();
        }
        foreach ($cuuList as $cuuItem) {
            $cuuItem->delete();
        }
        if ($delete) {
            $delete->delete();
        }

        return redirect()->route('SallesReturned.returned')->with("msg", "Deleted Successfully");
    }
}
