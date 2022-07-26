<?php

namespace App\Http\Controllers;

use App\Branches;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\Items;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\QtnItems;
use App\StoreModel;
use App\Transfers;
use App\TransfersList;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $list = Transfers::all();
        $list->each(function ($item) {
            $item->storeName1 = StoreModel::find($item->storeId1)->namear;
            $item->storeName2 = StoreModel::find($item->storeId2)->namear;
            $item->branch = Branches::find($item->branchId)->namear;
            $sources = DailyRestrictions::where('source', $item->id)->where('source_name', "تحويلات مخازن")->get();
            if (count($sources) == 1) {
                $item->source1 = DailyRestrictions::where('source', $item->id)->where('source_name', "تحويلات مخازن")->get()[0]->id;
                $item->source2 = "";
            }
            if (count($sources) == 2) {
                $item->source1 = DailyRestrictions::where('source', $item->id)->where('source_name', "تحويلات مخازن")->get()[0]->id;
                $item->source2 = DailyRestrictions::where('source', $item->id)->where('source_name', "تحويلات مخازن")->get()[1]->id;
            }
        });

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsTransfersStores" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsTransfersStores" )->first();
        }
        return view('stores.Transfers.index')->with('orders', $orders)->with('list', $list);
    }

    public function create()
    {
        $branches = Branches::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $stores = StoreModel::all();

        return view('stores.Transfers.create')
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('stores', $stores)
            ->with('branches', $branches);
    }

    public function getStoresByBranch($id)
    {
        $stores = StoreModel::where('branchId', $id)->get();
        return $stores;
    }

    public function getUnitsTransfers($id, $store)
    {
        if (!$store) {
            return response()->json([
                'msg' =>  "تاكد من بيانات المخزن",
                'status' => 201
            ]);
        }
        $storeId = $store;
        $list = Itemslist::where('itemId', $id)->get();
        foreach ($list as $item) {
            $item->storeId = $storeId;
        }
        $units = [];
        $list->each(function ($item, $storeId) {
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->item_name = Items::find($item->itemId)->namear;
            $item->cost = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->get()->first()->av_price;
            $item->units = Itemslist::where('itemId', $item->itemId)->get();
            $item->units->each(function ($row) {
                $row->unit_name = Unit::find($row->unitId)->namear;
            });

            $item->balance = QtnItems::where('item_id', $item->itemId)->where('store_id', $item->storeId)->get()->first();
            $item->small = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->where('small_unit', "=", 1)->get()->first();

            if (!$item->balance) {
                $item->balance = 0;
            }
            if ($item->balance) {
                $item->packing = Itemslist::where('itemId', $item->balance->item_id)->get()->first()->packing;
                $item->small_unit =  Unit::find($item->balance->unit_id)->namear;
            }
        });

        foreach ($list as $item) {
            $units[] = Unit::find($item->unitId);
        }
        return response()->json([
            'list' => $list,
            'units' => $units,
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {

        if (!$request->branchId) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من  بيانات الفرع');
        }
        if (!$request->storeId1) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من  بيانات المخزن');
        }
        if (!$request->storeId2) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من  بيانات المخزن');
        }
        $list = json_decode($request->list[0], true);
        $cost = 0;

        if (count($list) <= 0) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من اضافة البيانات');
        }

        if (count($list) > 0) {
            foreach ($list as $value) {
                if (!$value['itemId']) {
                    return redirect()
                        ->back()
                        ->with('msg', 'تاكد من اضافة البيانات كاملة للنصف في القائمة');
                }
                if (!$value['unitId']) {
                    return redirect()
                        ->back()
                        ->with('msg', 'تاكد من اضافة البيانات كاملة للوحدة في القائمة');
                }
                if (!$value['qtn']) {
                    return redirect()
                        ->back()
                        ->with('msg', 'تاكد من اضافة البيانات كاملة للكمية في القائمة');
                }
            }
        }


        // دي كدا تشيك
        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])->where('store_id', $request->storeId1)->first();
                    // return$qtn;
                    if (!$qtn) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في المخزن المحول منة');
                    }
                    $newQ = 0;
                    if ($itemCheck2['small_unit'] == 1) {
                        $newQ = $qtn->qtn;
                    } else {
                        $smal = Itemslist::where('itemId', $item['itemId'])
                            ->where('small_unit', '=', 1)
                            ->get()
                            ->first();
                        $newQ = $smal['packing'] * $qtn->qtn;
                    }
                    if ($newQ < $item['qtn']) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في المخزن المحول منة');
                    } else {
                        // المفروض هنا يخصم ويبيدل بئا
                    }
                }
            }
        }
        // دي للبروسيس
        if (count($list) > 0) {
            foreach ($list as $item) {
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])
                        ->where('store_id', $request->storeId1)
                        ->first();

                    $smal = Itemslist::where('itemId', $item['itemId'])
                        ->where('small_unit', '=', 1)
                        ->get()
                        ->first();
                    $newQ = 0;
                    if ($qtn) {
                        if ($itemCheck2['small_unit'] == 1) {
                            $newQ = $item['qtn'];
                        } else {
                            $newQ = $smal['packing'] * $item['qtn'];
                        }
                        if ($qtn->qtn < $item['qtn']) {
                            return redirect()
                                ->back()
                                ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                        } else {
                            // المفروض هنا يخصم ويبيدل بئا
                            $cost += $itemCheck2['av_price'];
                            $newQtnStore = QtnItems::where('unit_id', $item['unitId'])->where('item_id', $item['itemId'])->where('store_id', $request->storeId2)->first();
                            if (!$newQtnStore) {
                                QtnItems::create([
                                    'item_id' => $item['itemId'],
                                    'unit_id' => $item['unitId'],
                                    'store_id' => $request->storeId2,
                                    'qtn' => $newQ,
                                ]);
                                $qtn->qtn = $qtn->qtn - $newQ;
                                $qtn->save();
                            }
                            if ($newQtnStore) {
                                $qtn->qtn = $qtn->qtn - $newQ;
                                $newQtnStore->qtn = $newQtnStore->qtn + $newQ;
                                $qtn->save();
                                $newQtnStore->save();
                            }
                        }
                    } else {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في مخزن ' . StoreModel::find($request->storeId)->namear);
                    }
                }
            }
        }

        $last = Transfers::all()->last();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }

        $invoice = Transfers::create([
            'id' => $id,
            'branchId' => $request->branchId,
            'storeId1' => $request->storeId1,
            'storeId2' => $request->storeId2,
        ]);
        if ($request->date && $request->date != "") {
            $invoice->date = $request->date;
            $invoice->save();
        }
        if ($request->description && $request->description != "") {
            $invoice->description = $request->description;
            $invoice->save();
        }
        foreach ($list as $item) {
            TransfersList::create([
                'transferId' => $invoice->id,
                'itemId' => $item['itemId'],
                'unitId' => $item['unitId'],
                'qtn' => $item['qtn'],
            ]);
        }
        $this->createCuff($request, $invoice, $cost);

        return redirect()->route('Transfers.index')->with('msg', 'Successfult Created');
    }


    public function createCuff($data, $invoice, $cost)
    {
        $fiscal_year = FiscalYears::find(1);
        $last = DailyRestrictions::all()->last();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }
        // Cuff Account

        // المحول منة
        $store1 = StoreModel::find($data->storeId1);
        // المسلتم
        $store2 = StoreModel::find($data->storeId2);

        if ($cost != 0) {

            if ($store1->branchId == $store2->branchId) {
                $source = DailyRestrictions::create([
                    'id' => $id,
                    'fiscal_year' => $fiscal_year->code,
                    'document' => '',
                    'description' => '',
                    'branshId' => $data->branchId,
                    'source' => $invoice->id,
                    'source_name' => 'تحويلات مخازن',
                    'creditor' => $cost,
                    'debtor' => $cost,
                ]);

                DailyRestrictionsList::create([
                    'invoice_id' => $source->id,
                    'account_id' => $store1->id,
                    'account_name' => $store1->namear,
                    'debtor' => 0,
                    'creditor' => $cost,
                    'description' => '',
                ]);
                DailyRestrictionsList::create([
                    'invoice_id' => $source->id,
                    'account_id' => $store2->id,
                    'account_name' => $store2->namear,
                    'debtor' => $cost,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }


            if ($store1->branchId != $store2->branchId) {
                $source = DailyRestrictions::create([
                    'id' => $id,
                    'fiscal_year' => $fiscal_year->code,
                    'document' => '',
                    'description' => '',
                    'branshId' => $data->branchId,
                    'source' => $invoice->id,
                    'source_name' => 'تحويلات مخازن',
                    'creditor' => $cost,
                    'debtor' => $cost,
                ]);

                DailyRestrictionsList::create([
                    'invoice_id' => $source->id,
                    'account_id' => 17,
                    'account_name' => "تحويلات مخازن بين الفروع",
                    'debtor' => $cost,
                    'creditor' => 0,
                    'description' => '',
                ]);

                DailyRestrictionsList::create([
                    'invoice_id' => $source->id,
                    'account_id' => $store1->id,
                    'account_name' => $store1->namear,
                    'debtor' => 0,
                    'creditor' => $cost,
                    'description' => '',
                ]);
                //
                $source2 = DailyRestrictions::create([
                    'id' => $id + 1,
                    'fiscal_year' => $fiscal_year->code,
                    'document' => '',
                    'description' => '',
                    'branshId' => $store2->branchId,
                    'source' => $invoice->id,
                    'source_name' => 'تحويلات مخازن',
                    'creditor' => $cost,
                    'debtor' => $cost,
                ]);

                DailyRestrictionsList::create([
                    'invoice_id' => $source2->id,
                    'account_id' => $store2->id,
                    'account_name' => $store2->namear,
                    'debtor' => $cost,
                    'creditor' => 0,
                    'description' => '',
                ]);

                DailyRestrictionsList::create([
                    'invoice_id' => $source2->id,
                    'account_id' => 17,
                    'account_name' => "تحويلات مخازن بين الفروع",
                    'debtor' => 0,
                    'creditor' => $cost,
                    'description' => '',
                ]);
            }
        }



        return $source;
    }


    public function destroy($id)
    {
        $transfer = Transfers::find($id);
        $transferList = TransfersList::where('transferId', $id)->get();

        $cuff = DailyRestrictions::where('source', $id)->where('source_name', "تحويلات مخازن")->get();

        // دي كدا تشيك
        if (count($transferList) > 0) {
            foreach ($transferList as $item) {
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])->where('store_id', $transfer->storeId1)->first();
                    // return$qtn;
                    if (!$qtn) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في المخزن المحول منة');
                    }
                    $newQ = 0;
                    if ($itemCheck2['small_unit'] == 1) {
                        $newQ = $qtn->qtn;
                    } else {
                        $smal = Itemslist::where('itemId', $item['itemId'])
                            ->where('small_unit', '=', 1)
                            ->get()
                            ->first();
                        $newQ = $smal['packing'] * $qtn->qtn;
                    }
                    $newQtnStore = QtnItems::where('unit_id', $item['unitId'])->where('item_id', $item['itemId'])->where('store_id', $transfer->storeId1)->first();
                    $newQtnStore2 = QtnItems::where('unit_id', $item['unitId'])->where('item_id', $item['itemId'])->where('store_id', $transfer->storeId2)->first();
                    if ($item['qtn'] > $newQtnStore2->qtn) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يمكن حذف تحويل الاصناف لارتباطة بحركات');
                    }

                    if ($newQ < $item['qtn']) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في المخزن المحول منة');
                    } else {
                        // المفروض هنا يخصم ويبيدل بئا

                    }
                }
            }
        }

        // القيود
        if ($cuff) {
            if (count($cuff) == 1) {
                $cuffFirst = DailyRestrictions::where('source', $id)->where('source_name', "تحويلات مخازن")->first();
                $cuffFirstList = DailyRestrictionsList::where('invoice_id', $cuffFirst->id)->get();
                foreach ($cuffFirstList as $itemFirst) {
                    $itemFirst->delete();
                }
                $cuffFirst->delete();
            }

            if (count($cuff) == 2) {
                $cuff1 = DailyRestrictions::where('source', $id)->where('source_name', "تحويلات مخازن")->first();
                $cuffList1 = DailyRestrictionsList::where('invoice_id', $cuff1->id)->get();
                if (count($cuffList1) > 0) {
                    foreach ($cuffList1 as $item1) {
                        $item1->delete();
                    }
                }
                $cuff1->delete();
                //
                $cuff2 = DailyRestrictions::where('source', $id)->where('source_name', "تحويلات مخازن")->get()->last();
                $cuffList2 = DailyRestrictionsList::where('invoice_id', $cuff2->id)->get();
                if (count($cuffList2) > 0) {
                    foreach ($cuffList2 as $item2) {
                        $item2->delete();
                    }
                }
                $cuff2->delete();
                // return $cuffList2;
            }
        }

        // دي للبروسيس
        if (count($transferList) > 0) {
            foreach ($transferList as $item) {
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])
                        ->where('store_id', $transfer->storeId1)
                        ->first();

                    $smal = Itemslist::where('itemId', $item['itemId'])
                        ->where('small_unit', '=', 1)
                        ->get()
                        ->first();
                    $newQ = 0;
                    if ($qtn) {
                        if ($itemCheck2['small_unit'] == 1) {
                            $newQ = $item['qtn'];
                        } else {
                            $newQ = $smal['packing'] * $item['qtn'];
                        }
                        if ($qtn->qtn < $item['qtn']) {
                            return redirect()
                                ->back()
                                ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                        } else {
                            // المفروض هنا يخصم ويبيدل بئا
                            $newQtnStore = QtnItems::where('unit_id', $item['unitId'])->where('item_id', $item['itemId'])->where('store_id', $transfer->storeId1)->first();
                            $newQtnStore2 = QtnItems::where('unit_id', $item['unitId'])->where('item_id', $item['itemId'])->where('store_id', $transfer->storeId2)->first();
                            if ($newQtnStore) {
                                $newQtnStore->qtn = $newQtnStore->qtn + $newQ;
                                $newQtnStore2->qtn = $newQtnStore2->qtn - $newQ;
                                $newQtnStore2->save();
                                $newQtnStore->save();
                            }
                        }
                    } else {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في مخزن ' . StoreModel::find($transfer->storeId1)->namear);
                    }
                }
            }
        }


        foreach ($transferList as $transferItem) {
            $transferItem->delete();
        }
        if ($transfer) {
            $transfer->delete();
        }


        return redirect()->route('Transfers.index')->with('msg', 'Successfult Deleted !');
    }
}
