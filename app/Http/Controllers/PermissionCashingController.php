<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Customers;
use App\Items;
use App\Itemslist;
use App\OrderPages;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\Powers;
use App\StoreModel;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCashingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsOrderCashing');
        $this->middleware('active_permision');
    }

    public function index()
    {

        $savedSalles = PermissionCashingList::all();
        $Invoices = PermissionCashing::all();
        $customers = Customers::all();
        $suppliers = Supplier::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsOrderCashing" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsOrderCashing" )->first();
        }
        return view('PermissionCashing.index')
            ->with('Invoices', $Invoices)
            ->with('savedSalles', $savedSalles)
            ->with('orders', $orders)
            ->with('suppliers', $suppliers)
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
        $purchaseId = PermissionCashing::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = PermissionCashing::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }
        return view('PermissionCashing.create')
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
        if ($request->payment == "1") {
            $request->payment = 3;
        }

        if (count($list) < 0) {
            return redirect()->back();
        }

        $invoice = PermissionCashing::create([
            'branchId' => $request->branchId,
            'status' => $request->payment,
            'netTotal' => $netTotalList,
            'customerId' => $request->customerId,
            'storeId' => $request->storeId,
        ]);



        if (count($list) > 0) {
            foreach ($list as $item) {
                PermissionCashingList::create([
                    'invoiceId' => $invoice->id,
                    'storeId' => $item['storeId'],
                    'itemId' => $item['itemId'], // --
                    'unitId' => $item['unitId'], // --
                    'qtn' => $item['qtn'], // --
                ]);
            }
        }
        return redirect()->route('permission_cashing.index');
    }


    public function edit($id)
    {
        $branches = Branches::all();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $invocie = PermissionCashing::find($id);
        // return $invocie;
        $invoiceList = PermissionCashingList::where('invoiceId', $id)->get();
        // return $invoiceList;
        return view('PermissionCashing.edit')
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
        if ($request->payment == "1") {
            $request->payment = 3;
        }


        $invoice = PermissionCashing::find($id);
        if (!empty($list)) {
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($item['discount'] * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = 0;
                    $addedN = "";
                    if (isset($item['added'])) {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $itemDetails = Items::find($item['itemId']);
                    PermissionCashingList::create([
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

                $itemUpdate = PermissionCashingList::find($item['id']);
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
        return redirect()->route('permission_cashing.index');
    }



    public function destroy($id)
    {
        $delete = PermissionCashing::findorFail($id);
        if($delete->source == "فاتورة بيع" || $delete->source == "مبيعات") {
            return redirect()->back()->with('msg', 'لا يمكن حذف اذن صرف مصدر مبيعات');
        }
        $saved = PermissionCashingList::where('invoiceId', $id)->get();
        foreach ($saved as $invoice) {
            $invoice->delete();
        }
        $status = $delete->delete();

        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('permission_cashing.index');
    }
}
