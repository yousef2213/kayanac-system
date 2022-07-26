<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\CostCenters;
use App\Customers;
use App\FiscalYears;
use App\Items;
use App\Itemslist;
use App\OfferPrice;
use App\OfferPriceList;
use App\OrderPages;
use App\Powers;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsInvoiceSales');
    }

    public function index()
    {
        $savedSalles = OfferPriceList::all();
        $Invoices = OfferPrice::all();
        $Invoices->each(function ($invoice) {
            $invoice->customer_name = Customers::find($invoice->customerId)->name;
            $invoice->branch_name = Branches::find($invoice->branchId)->namear;
        });

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsPriceOfferSalles" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsPriceOfferSalles" )->first();
        }

        return view('Salles.OfferPrice.index')
            ->with('Invoices', $Invoices)
            ->with('orders', $orders)
            ->with('savedSalles', $savedSalles);
    }

    public function create()
    {
        $company = Compaines::all()->first();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $branches = Branches::all();
        $customer = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $purchaseId = OfferPrice::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = OfferPrice::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }
        return view('Salles.OfferPrice.create')
            ->with('costCenters', $costCenters)
            ->with('customer', $customer)
            ->with('company', $company)
            ->with('stores', $stores)
            ->with('id', $id)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function store(Request $request)
    {
        $acc = Customers::find($request->customerId);
        $list = json_decode($request->list[0], true);
        $netTotalList = 0;
        $totals = 0;
        $average_total = 0;
        $taxs = 0;
        // return $request;
        if (count($list) > 0) {
            foreach ($list as $item) {
                if (!isset($item['itemId'])) {
                    return redirect()
                        ->back()
                        ->with('error', 'من فضلك تاكد من البيانات');
                }
                if (!isset($item['unitId'])) {
                    return redirect()
                        ->back()
                        ->with('error', 'من فضلك تاكد من البيانات');
                }
                if (!isset($item['storeId'])) {
                    return redirect()
                        ->back()
                        ->with('error', 'من فضلك تاكد من البيانات');
                }
                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                if (!$itemCheck) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا توجد هذة الوحدة للصنف ');
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
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'من فضلك تاكد من البيانات');
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

        $fiscal_year = FiscalYears::all()->first();

        $id = 1;
        $last_invoice = OfferPrice::all()->last();
        if ($last_invoice) {
            $id = $last_invoice->id + 1;
        }
        $invoice = OfferPrice::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'branchId' => $request->branchId,
            'status' => $request->payment,
            'netTotal' => $netTotalList,
            'customerId' => $request->customerId,
        ]);
        if ($request->taxSourceValue) {
            $invoice->netTotal = $netTotalList - $request->taxSourceValue;
            $invoice->save();
        }
        if ($request->date_follow != "") {
            $invoice->date_follow = $request->date_follow;
            $invoice->save();
        }
        if ($request->taxSource) {
            $invoice->taxSource = $request->taxSource;
            $invoice->save();
        }

        if ($request->costCenter) {
            $invoice->cost_center = $request->costCenter;
            $invoice->save();
        }

        if ($request->discountAdded) {
            $invoice->netTotal = $netTotalList - $request->discountAdded;
            $invoice->discount_added = $request->discountAdded;

            $invoice->save();
        }

        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $diss = 0;
                $description = null;
                if (isset($item['discount']) && $item['discount'] != '') {
                    $diss = $item['discount'];
                }
                if (isset($item['description'])) {
                    $description = $item['description'];
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
                OfferPriceList::create([
                    'invoiceId' => $invoice->id,
                    'customer_id' => $request->customerId,
                    'storeId' => $item['storeId'],
                    'item_id' => $item['itemId'], // --
                    'unit_id' => $item['unitId'], // --
                    'qtn' => $item['qtn'], // --
                    'price' => $item['price'], // --
                    'discountRate' => $diss, // --
                    'discountValue' => $discountValue, // --
                    'price' => $item['price'], // --
                    'item_name' => $itemDetails->namear, // --
                    'nettotal' => $nettotal, // --
                    'rate' => $addedN, // --
                    'total' => $totalBefore, // --
                    'value' => $value,
                    'description' => $description,
                ]);
            }
        }

        return redirect()->route('offer-price.index')->with('msg' , "Successfuly Added");
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $invocie = OfferPrice::find($id);
        $company = Compaines::all()->first();
        $invoiceList = OfferPriceList::where('invoiceId', $invocie->id)->get();
        // return $invocie;
        return view('Salles.OfferPrice.edit')
            ->with('invocie', $invocie)
            ->with('costCenters', $costCenters)
            ->with('company', $company)
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
        $lastTotal = 0;
        $totalBeforCalculation = 0;
        $average_total = 0;
        $newList = [];
        $taxs = 0;
        $totals = 0;
        if (count($list) > 0) {
            foreach ($list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $average_total += $item['av_price'];
                $newList[] = $item;
            }
        }

        $invoice = OfferPrice::find($id);
        if ($request->costCenter && $request->costCenter != '') {
            $invoice->cost_center = $request->costCenter;
            $invoice->save();
        }

        if ($request->taxSource) {
            $invoice->taxSource = $request->taxSource;
            $invoice->save();
        }
        if ($request->date_follow != "") {
            $invoice->date_follow = $request->date_follow;
            $invoice->save();
        }

        if ($request->taxSourceValue) {
            $invoice->netTotal = $totalBeforCalculation - $request->taxSourceValue;
            $invoice->save();
        }

        if ($request->discountAdded) {
            $invoice->netTotal = $totalBeforCalculation - $request->taxSourceValue - $request->discountAdded;;
            $invoice->discount_added = $request->discountAdded;
            $invoice->save();
        }

        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $dis = 0;
                if (isset($item['discount']) && $item['discount'] != 0) {
                    $dis = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($dis * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } elseif (isset($item['rate'])) {
                    $value = ($total * $item['rate']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $lastTotal += $nettotal;
                $taxs += $value;
                $totals += $total;
            }
        }

        if (count($newList) > 0) {
            foreach ($newList as $item) {
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
                    OfferPriceList::create([
                        'invoiceId' => $invoice->id,
                        'customer_id' => $request->customerId,
                        'storeId' => $item['storeId'],
                        'item_id' => $item['itemId'], // --
                        'unit_id' => $item['unitId'], // --
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
                    $itemUpdate = OfferPriceList::find($item['id']);
                    if ($item['storeId']) {
                        $itemUpdate->storeId = $item['storeId'];
                        $itemUpdate->save();
                    }
                    if ($item['itemId']) {
                        $itemUpdate->item_id = $item['itemId'];
                        $itemUpdate->save();
                    }
                    if ($item['unitId']) {
                        $itemUpdate->unit_id = $item['unitId'];
                        $itemUpdate->save();
                    }

                    if ($item['qtn'] && $item['price']) {
                        $old_qtn = $itemUpdate->qtn;
                        $new_qtn = $item['qtn'];
                        $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                            ->where('unitId', $item['unitId'])
                            ->first();

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

        $invoice->customerId = $request->customerId;
        $invoice->status = $request->payment;
        $invoice->branchId = $request->branchId;
        $invoice->netTotal = $lastTotal - $request->taxSourceValue - $request->discountAdded;
        $invoice->save();

        return redirect()->route('offer-price.index');
    }

    public function deleteRow($id)
    {
        $saved = OfferPriceList::find($id);
        $saved->delete();
        return response()->json([
            'status' => 200,
            'id' => $id,
        ]);
    }

    public function destroy($id)
    {

        $delete = OfferPrice::findorFail($id);
        $saved = OfferPriceList::where('invoiceId', $id)->get();

        foreach ($saved as $invoice) {
            $invoice->delete();
        }

        if ($delete) {
            $delete->delete();
        }
        return redirect()
            ->route('offer-price.index')
            ->with('success', 'Successfully deleted');
    }

    public function print($id)
    {
        $company = Compaines::find(1);
        $branch = Branches::find(1);
        $invoice = OfferPrice::find($id);
        $list = OfferPriceList::where('invoiceId', $id)->get();
        $customer = Customers::find($invoice->customerId);
        // return $customer;
        return view('Salles.OfferPrice.print')
            ->with('company', $company)
            ->with('invoice', $invoice)
            ->with('list', $list)
            ->with('customer', $customer)
            ->with('branch', $branch);
    }
}
