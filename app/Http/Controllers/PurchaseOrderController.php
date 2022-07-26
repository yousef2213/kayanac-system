<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\FiscalYears;
use App\Items;
use App\Itemslist;
use App\PurchaseOrder;
use App\PurchaseOrderList;
use App\StoreModel;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $purchases = PurchaseOrder::all();
        $suppliers = Supplier::all();
        $branches = Branches::all();
        return view('Purchases.PurchasesOrder.index')
            ->with('branches', $branches)
            ->with('suppliers', $suppliers)
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
        $purchaseId = PurchaseOrder::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = PurchaseOrder::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }
        return view('Purchases.PurchasesOrder.create')
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
        $netTotalList = 0;
        $taxs = 0;
        $totals = 0;
        $average_total = 0;

        $list = json_decode($request->list[0], true);
        $new_list = [];

        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemPurchase = PurchaseOrderList::where('itemId', $item['itemId'])
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
                $new_list[] = $item;
            }
        }
        $fiscal_year = FiscalYears::all()->first();

        $idInoivePurcahe = 1;
        $lastIdId = PurchaseOrder::all()->last();
        if ($lastIdId) {
            $idInoivePurcahe = $lastIdId->id + 1;
        }
        $purchase = PurchaseOrder::create([
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
        if ($request->date_follow != "") {
            $purchase->date_follow = $request->date_follow;
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


        if ($request->dateInvoice != "") {
            $purchase->dateInvoice = $request->dateInvoice;
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
                PurchaseOrderList::create([
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
        }

        return redirect()->route('purchase-order.index')->with('Successfuly Added');
    }

    public function show($id)
    {
        //
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
        $purchase = PurchaseOrder::find($id);
        $purchaseList = PurchaseOrderList::where('purchasesId', $id)->get();
        $nettotal = 0;
        $taxValue = 0;
        foreach ($purchaseList as $item) {
            $nettotal = $item['total'];
            $taxValue = $item['value'];
        }
        return view('Purchases.PurchasesOrder.edit')
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

        $list = json_decode($request->list[0], true);
        $new_list = [];

        $purchase = PurchaseOrder::find($id);

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


        if ($request->dateInvoice != "") {
            $purchase->dateInvoice = $request->dateInvoice;
            $purchase->save();
        }


        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemPurchase = PurchaseOrderList::where('itemId', $item['itemId'])
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
                $new_list[] = $item;
            }
        }



        if (count($new_list) > 0) {
            foreach ($new_list as $item) {
                if ($item['isNew'] == true) {
                    $disco = 0;
                    if (isset($item['discount']) && $item['discount'] != 0) {
                        $disco = $item['discount'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($disco * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = 0;
                    $addedN = '';
                    if (isset($item['added']) && $item['added'] != '') {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $itemDetails = Items::find($item['itemId']);
                    $description = null;
                    if (isset($item['description'])) {
                        $description = $item['description'];
                    }
                    PurchaseOrderList::create([
                        'purchasesId' => $purchase->id,
                        'customer_id' => $request->customerId,
                        'storeId' => $item['storeId'],
                        'itemId' => $item['itemId'], // --
                        'unitId' => $item['unitId'], // --
                        'qtn' => $item['qtn'], // --
                        'price' => $item['price'], // --
                        'discountRate' => $disco, // --
                        'discountValue' => $discountValue, // --
                        'price' => $item['price'], // --
                        'item_name' => $itemDetails->namear, // --
                        'nettotal' => $nettotal, // --
                        'rate' => $addedN, // --
                        'total' => $totalBefore, // --
                        'value' => $value,
                        'description' => $description,
                    ]);
                } else {
                    $itemUpdate = PurchaseOrderList::find($item['id']);
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

                    if ($item['qtn'] && $item['price']) {

                        $dis = 0;
                        $ad = $itemUpdate->rate;
                        if (isset($item['discount']) && $item['discount'] != '') {
                            $dis = $item['discount'];
                        }
                        $totalBefore = $item['qtn'] * $item['price'];
                        $discountValue = ($dis * $totalBefore) / 100;
                        $total = $item['qtn'] * $item['price'] - $discountValue;
                        if (isset($item['added']) && $item['added'] != '') {
                            $itemUpdate->rate = $item['added'];
                            $itemUpdate->save();
                        }

                        $value = ($total * $ad) / 100;
                        $nettotal = $total + $value;
                        $itemUpdate->discountValue = $discountValue;
                        $itemUpdate->discountRate = $dis;

                        $itemUpdate->total = $total;
                        $itemUpdate->value = $value;
                        $itemUpdate->nettotal = $nettotal;
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
                    if (isset($item['discount']) && $item['discount'] != '') {
                        $itemUpdate->discountRate = $item['discount'];
                        $itemUpdate->save();
                    }
                }
            }
        }

        // ////////

        return redirect()->route('purchase-order.index')->with('msg', 'Successfult Updated');
    }


    public function deleteRow($id)
    {
        $saved = PurchaseOrderList::find($id);
        $saved->delete();
        return response()->json([
            'status' => 200,
            'id' => $id,
        ]);
    }

    public function destroy($id)
    {
        $purchase = PurchaseOrder::find($id);
        $purchaseList = PurchaseOrderList::where('purchasesId', $id)->get();
        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {
                $purchaseItem->delete();
            }
        }

        if ($purchase) {
            $purchase->delete();
        }
        return redirect()->route('purchase-order.index')->with('msg', "Deleted Successfully");
    }
}
