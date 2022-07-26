<?php

namespace App\Http\Controllers;

use App\Items;
use App\Itemslist;
use App\OpeningBalance;
use App\OpeningBalanceList;
use App\OrderPages;
use App\Powers;
use App\Purchases;
use App\PurchasesList;
use App\QtnItems;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpeningBalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsStoresOpeningBalance');
        $this->middleware('active_permision');
    }
    public function index()
    {
        $list = OpeningBalanceList::all();
        $list->each(function ($item) {
            $item->storeId = OpeningBalance::find($item->invoice_id)->storeId;
            $item->store_name = StoreModel::find(OpeningBalance::find($item->invoice_id)->storeId)->namear;
            $item->item_name = Items::find($item->itemId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
        });
        $total = 0;
        foreach ($list as $value) {
            $total += $value->nettotal;
        }


        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsStoresOpeningBalance" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsStoresOpeningBalance" )->first();
        }

        return view('OpeneningBalance.index')->with('orders', $orders)->with('list', $list)->with('total', $total);
    }

    public function create()
    {
        $stores = StoreModel::all();
        $items = items::all();
        $itemList = Itemslist::all();
        $units = Unit::all();

        return view('OpeneningBalance.create')
            ->with('items', $items)
            ->with('units', $units)
            ->with('itemList', $itemList)
            ->with('stores', $stores);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "storeId" => "require"
        ]);
        $list = json_decode($request->list[0], true);
        // return  $request;

        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                if (!$itemCheck) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا توجد هذة الوحدة للصنف من فضلك قم باضافتها اولا');
                }
            }
        }

        $invoice = OpeningBalance::create([
            'storeId' => $request->store_id,
        ]);

        if (count($list) > 0) {
            foreach ($list as $item) {




                $itemPurchase = PurchasesList::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->where('storeId', $request->store_id)
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
                $item['av_price'] = $totalP / $totalQ;


                $itemAv = Itemslist::where('itemId', $item['itemId'])->get();
                $itemHere = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                $itemHere->av_price = $item['av_price'];
                $itemHere->save();

                // foreach ($itemAv as $item_av) {
                //     if ($item_av['small_unit'] == 1) {
                //         $item_av->av_price = $item['price'] / $itemHere->packing;
                //         $item_av->save();
                //     }
                // }

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
                OpeningBalanceList::create([
                    'invoice_id' => $invoice->id,
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
                $this->saveQtn($item['itemId'], $item['unitId'], $request->store_id, $item['qtn']);
            }
        }


        return redirect()->route('opening_balance.index')->with('msg', "Successfully added");
    }
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



    public function show($id)
    {
        //
    }




    public function edit()
    {
        return view('Purchases.edit');
    }

    public function update(Request $request, $id)
    {
        $list = json_decode($request->list[0], true);
        $purchase = Purchases::find($id);
        $purchaseList = PurchasesList::where('purchasesId', $id)->get();
        if (!empty($list)) {
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($item['discount'] * $totalBefore) / 100;
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
                        'discountRate' => $item['discount'],
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
        $purchase->supplier = $request->supplier;
        $purchase->supplier_invoice = $request->supplier_invoice;
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

                    $itemUpdate->nettotal = $nettotal;
                    $itemUpdate->save();
                }
            }
        }

        return redirect()->route('ItemsPurchases.index');
    }

    public function destroy($id)
    {
        $invoice = OpeningBalance::find($id);
        $invoiceList = OpeningBalanceList::where('invoice_id', $id)->get();









        if (count($invoiceList) > 0) {
            foreach ($invoiceList as $purchaseItem) {

                $status = Itemslist::where('itemId', $purchaseItem['itemId'])
                    ->where('unitId', $purchaseItem['unitId'])
                    ->first();
                // return $status->av_price;
                $itemPurchase = PurchasesList::where('itemId', $status['itemId'])
                    ->where('unitId', $status['unitId'])
                    ->where('storeId', $invoice->storeId)
                    ->get();


                $check = QtnItems::where('item_id', $purchaseItem['itemId'])
                    ->where('store_id', $invoice->storeId)
                    ->first();
                if ($check) {
                    $check->qtn = $check->qtn - $status->packing * $purchaseItem['qtn'];
                    $check->save();
                }
                $purchaseItem->delete();


                $totalP = 0; // اجمالي التكلفة
                $pids = [];
                // return $itemPurchase;
                if(count($itemPurchase) <= 0){
                    $status->av_price = 0;
                    $status->save();
                }else {

                    foreach ($itemPurchase as $h) {
                        $pids[] = $h['total'];
                    }
                    $uniquePids = array_unique($pids);
                    foreach ($uniquePids as $p) {
                        $totalP += $p;
                    }
                    $totalP += $purchaseItem['qtn'] * $purchaseItem['price'];

                    $totalQ = 0; // اجمالي العدد
                    $pidsQ = [];
                    foreach ($itemPurchase as $h) {
                        $pidsQ[] = $h['qtn'];
                    }
                    $uniquePidsQ = array_unique($pidsQ);
                    foreach ($uniquePidsQ as $p2) {
                        $totalQ += $p2;
                    }
                    $totalQ += $purchaseItem['qtn'];
                    $itemCheck = Itemslist::where('itemId', $purchaseItem['itemId'])
                    ->where('unitId', $purchaseItem['unitId'])
                    ->first();
                    $purchaseItem['av_price'] = $totalP / $totalQ;

                    $itemAv = Itemslist::where('itemId', $purchaseItem['itemId'])->get();
                    $itemHere = Itemslist::where('itemId', $purchaseItem['itemId'])->where('unitId', $purchaseItem['unitId'])->first();
                    $itemHere->av_price = $purchaseItem['av_price'];
                    $itemHere->save();

                    foreach ($itemAv as $item_av) {
                        if ($item_av['small_unit'] == 1) {
                            $item_av->av_price = $purchaseItem['price'] / $itemHere->packing;
                            $item_av->save();
                        }
                    }

                }

            }
        }






        if ($invoice) {
            $invoice->delete();
        }

        return redirect()->route('opening_balance.index')->with('msg', 'Successfully Deleted');
    }
}
