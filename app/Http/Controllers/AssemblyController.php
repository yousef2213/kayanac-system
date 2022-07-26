<?php

namespace App\Http\Controllers;

use App\Items;
use App\ItemsAssembly;
use App\SavedInvoices;
use App\ItemsAssemblyList;
use App\ItemsCollection;
use App\ItemsCollectionList;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\QtnItems;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssemblyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $itemCollection = ItemsAssembly::all();
        $itemCollection->each(function ($item) {
            $item->item_name = Items::find($item->itemId)->namear;
            $item->store_name = StoreModel::find($item->storeId)->namear;
            $item->unit_name = Unit::find(
                Itemslist::where('itemId', $item->itemId)
                    ->get()
                    ->first()->unitId,
            )->namear;
        });


        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCollectionOfItems" )->first();
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
            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCollectionOfItems" )->first();
        }
        return view('ItemsCollection.assembly.index')
            ->with('orders', $orders)
                ->with('itemCollection', $itemCollection);
    }

    public function create()
    {
        $items = Items::where('item_type', 2)->get();
        $itemsCreate = Items::where('item_type', '!=', 2)->get();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $stores = StoreModel::all();
        return view('ItemsCollection.assembly.create')
            ->with('items', $items)
            ->with('itemsCreate', $itemsCreate)
            ->with('stores', $stores)
            ->with('units', $units)
            ->with('itemsList', $itemsList);
    }

    public function getItemCollection($id)
    {
        // return $id;
        $item = Items::find($id);
        $list = Itemslist::where('itemId', $id)->get();

        $item = ItemsCollection::where('itemId', $id)
            ->get()
            ->first();
        $list = ItemsCollectionList::where('collection_id', $item->id)->get();
        // return$list;
        $list->each(function ($item) {
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->item_name = Items::find($item->itemId)->namear;
            $item->cost = Itemslist::where('itemId', $item->itemId)
                ->where('unitId', $item->unitId)
                ->get()
                ->first()->av_price;
            $item->units = Itemslist::where('itemId', $item->itemId)->get();
            $item->units->each(function ($row) {
                $row->unit_name = Unit::find($row->unitId)->namear;
            });

            $item->balance = QtnItems::where('item_id', $item->itemId)
                ->get()
                ->first();
            $item->small = Itemslist::where('itemId', $item->itemId)
                ->where('unitId', $item->unitId)
                ->where('small_unit', '=', 1)
                ->get()
                ->first();

            if (!$item->balance) {
                $item->balance = 0;
            }
            if ($item->balance) {
                $item->packing = Itemslist::where('itemId', $item->balance->item_id)
                    ->get()
                    ->first()->packing;
                $item->small_unit = Unit::find($item->balance->unit_id)->namear;
            }
        });
        return response()->json([
            'item' => $item,
            'list' => $list,
        ]);
    }

    public function store(Request $request)
    {
        $list = json_decode($request->list[0], true);
        if (!$request->storeId) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من  بيانات المخزن');
        }
        if (!$request->itemId) {
            return redirect()
                ->back()
                ->with('msg', ' تاكد من  بيانات الصنف');
        }
        if (!$request->qttn) {
            return redirect()
                ->back()
                ->with('msg', ' تاكد من  بيانات كمية الصنف');
        }

        $list = json_decode($request->list[0], true);
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
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])->first();
                    if (!$qtn) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
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
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                    } else {
                        // المفروض هنا يخصم ويبيدل بئا
                    }
                }
            }
        }

        $basciunitId = 0;
        $cost = 0;
        $basic = ItemsCollection::where('itemId', $request->itemId)->first();
        if ($basic) {
            $basciunitId = $basic->unitId;
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
                        ->where('store_id', $request->storeId)
                        ->first();

                    $smal = Itemslist::where('itemId', $item['itemId'])
                        ->where('small_unit', '=', 1)
                        ->get()
                        ->first();
                    $newQ = 0;
                    if ($qtn) {
                        if ($itemCheck2['small_unit'] == 1) {
                            $newQ = $qtn->qtn;
                        } else {
                            $newQ = $smal['packing'] * $qtn->qtn;
                        }
                        if ($newQ < $item['qtn']) {
                            return redirect()
                                ->back()
                                ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                        } else {
                            // المفروض هنا يخصم ويبيدل بئا
                            $cost += $smal['av_price'];
                            $qtn->qtn = $newQ - $item['qtn'];
                            $qtn->save();
                        }
                    } else {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في مخزن ' . StoreModel::find($request->storeId)->namear);
                    }
                }
            }
        }

        $bas = Itemslist::where('itemId', $request->itemId)
            ->where('small_unit', '=', 1)
            ->first();
        $check = QtnItems::where('item_id', $request->itemId)
            ->where('store_id', $request->storeId)
            ->first();
        if ($check) {
            $check->qtn = $check->qtn + $request['qtn'];
            $check->save();
        } else {
            QtnItems::create([
                'item_id' => $request['itemId'],
                'unit_id' => $basciunitId,
                'store_id' => $request['storeId'],
                'qtn' => $bas->packing * $request->qttn,
            ]);
        }

        $id = 1;
        $lastId = ItemsAssembly::all()->last();
        if ($lastId) {
            $id = $lastId->id + 1;
        }
        $product = ItemsAssembly::create([
            'id' => $id,
            'itemId' => $request->itemId,
            'unitId' => $basciunitId,
            'storeId' => $request->storeId,
            'qtn' => $request->qttn,
            'description' => $request->description,
            'cost' => $cost,
        ]);
        $bas->av_price = $cost;
        $bas->save();
        foreach ($list as $item) {
            ItemsAssemblyList::create([
                'assembly_id' => $product->id,
                'itemId' => $item['itemId'],
                'unitId' => $item['unitId'],
                'qtn' => $item['qtn'],
            ]);
        }

        return redirect()
            ->route('assembly.index')
            ->with('msg', 'Successfuly Created');
    }

    public function edit($id)
    {
        $product = ItemsAssembly::find($id);
        $list = ItemsAssemblyList::where('assembly_id', $id)->get();
        $list->each(function ($row) {
            $row->itemName = Items::find($row->itemId)->namear;
            $row->units = ItemsList::where('itemId', $row->itemId)->get();
            $row->cost = Itemslist::where('itemId', $row->itemId)
                ->where('unitId', $row->unitId)
                ->get()
                ->first()->av_price;
            $row->units->each(function ($unit) {
                $unit->unitName = Unit::find($unit->unitId)->namear;
            });

            $row->balance = QtnItems::where('item_id', $row->itemId)
                ->get()
                ->first();
            $row->small = Itemslist::where('itemId', $row->itemId)
                ->where('unitId', $row->unitId)
                ->where('small_unit', '=', 1)
                ->get()
                ->first();

            if (!$row->balance) {
                $row->balance = 0;
            }
            if ($row->balance) {
                $row->packing = Itemslist::where('itemId', $row->balance->item_id)
                    ->get()
                    ->first()->packing;
                $row->small_unit = Unit::find($row->balance->unit_id)->namear;
            }
        });

        $items = Items::where('item_type', 2)->get();
        $itemsCreate = Items::where('item_type', '!=', 2)->get();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $stores = StoreModel::all();
        return view('ItemsCollection.assembly.edit')
            ->with('items', $items)
            ->with('product', $product)
            ->with('list', $list)
            ->with('itemsCreate', $itemsCreate)
            ->with('stores', $stores)
            ->with('units', $units)
            ->with('itemsList', $itemsList);
    }

    public function update(Request $request, $id)
    {
        $cost = 0;
        $list = json_decode($request->list[0], true);
        if (!$request->storeId) {
            return redirect()
                ->back()
                ->with('msg', 'تاكد من  بيانات المخزن');
        }
        if (!$request->itemId) {
            return redirect()
                ->back()
                ->with('msg', ' تاكد من  بيانات الصنف');
        }

        if (!$request->qttn) {
            return redirect()
                ->back()
                ->with('msg', ' تاكد من  بيانات كمية الصنف');
        }

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
                if (!isset($value['unitId']) || !$value['unitId']) {
                    return redirect()
                        ->back()
                        ->with('msg', 'تاكد من اضافة البيانات كاملة للوحدة في القائمة');
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
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])->first();
                    if (!$qtn) {
                        return redirect()
                            ->back()
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
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
                            ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                    } else {
                        // المفروض هنا يخصم ويبيدل بئا
                    }
                }
            }
        }

        // دي للبروسيس
        if (count($list) > 0) {
            foreach ($list as $item) {
                $oldItemList = ItemsAssemblyList::find($item['id']);
                // return $oldItemList->qtn;
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])
                        ->where('store_id', $request->storeId)
                        ->first();

                    $smal = Itemslist::where('itemId', $item['itemId'])
                        ->where('small_unit', '=', 1)
                        ->get()
                        ->first();
                    $newQ = 0;
                    if ($qtn) {
                        if ($itemCheck2['small_unit'] == 1) {
                            $newQ = $qtn->qtn;
                        } else {
                            $newQ = $smal['packing'] * $qtn->qtn;
                        }

                        if ($newQ < $item['qtn']) {
                            return redirect()
                                ->back()
                                ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                        } else {
                            // المفروض هنا يخصم ويبيدل بئا
                            if ($item['isNew'] == true) {
                                $cost += $smal['av_price'];
                                $qtn->qtn = $newQ - $item['qtn'];
                                $qtn->save();
                            }

                            if ($item['isNew'] == false) {
                                $cost += $smal['av_price'];
                                if ($item['qtn'] > $oldItemList->qtn) {
                                    $mustChange = $item['qtn'] - $oldItemList->qtn;
                                    $oldItemList->qtn = $item['qtn'];
                                    $qtn->qtn = $newQ - $mustChange;
                                    $oldItemList->save();
                                    $qtn->save();
                                }
                                if ($item['qtn'] < $oldItemList->qtn) {
                                    $mustChange = $oldItemList->qtn - $item['qtn'];
                                    $oldItemList->qtn = $item['qtn'];
                                    $qtn->qtn = $newQ + $mustChange;
                                    $oldItemList->save();
                                    $qtn->save();
                                }
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

        foreach ($list as $item) {
            if ($item['isNew'] == true) {
                ItemsAssemblyList::create([
                    'assembly_id' => $id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                ]);
            }

            if ($item['isNew'] == false) {
                $oldItemList = ItemsAssemblyList::find($item['id']);
                if (isset($item['itemId']) && $item['itemId'] != '') {
                    $oldItemList->itemId = $item['itemId'];
                    $oldItemList->save();
                }
                if (isset($item['unitId']) && $item['unitId'] != '') {
                    $oldItemList->unitId = $item['unitId'];
                    $oldItemList->save();
                }
            }
        }

        $product = ItemsAssembly::find($id);
        $product->cost = $cost;

        $bas = Itemslist::where('itemId', $request->itemId)
            ->where('small_unit', '=', 1)
            ->first();
        $check = QtnItems::where('item_id', $request->itemId)
            ->where('store_id', $request->storeId)
            ->first();
        $Qtnqtn = $bas->packing * $request->qttn;
        // return $check;
        if ($request->qttn > $product->qtn) {
            $savedQtn = $request->qttn - $product->qtn;
            $check->qtn = $check->qtn + $savedQtn;
            $check->save();
        }
        if ($request->qttn < $product->qtn) {
            $savedQtn = $product->qtn - $request->qttn;
            $check->qtn = $check->qtn - $savedQtn;
            $check->save();
        }
        $product->qtn = $request->qttn;
        $product->storeId = $request->storeId;
        if ($request->description) {
            $product->description = $request->description;
            $product->save();
        }
        $product->save();

        return redirect()
            ->route('assembly.index')
            ->with('msg', 'Successfuly Updated');
    }

    public function deleteRow($id)
    {
        $saved = ItemsAssemblyList::find($id);
        $basic = ItemsAssembly::find($saved->assembly_id);

        $itemCheck2 = Itemslist::where('itemId', $saved['itemId'])
            ->where('unitId', $saved['unitId'])
            ->first();
        $MainItem = Items::find($itemCheck2->itemId);
        if ($MainItem->item_type != 3) {
            $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])
                ->where('store_id', $basic->storeId)
                ->first();

            $smal = Itemslist::where('itemId', $saved['itemId'])
                ->where('small_unit', '=', 1)
                ->get()
                ->first();

            if ($qtn) {
                if ($itemCheck2['small_unit'] == 1) {
                    $newQ = $qtn->qtn;
                } else {
                    $newQ = $smal['packing'] * $qtn->qtn;
                }

                if ($newQ < $saved['qtn']) {
                    return redirect()
                        ->back()
                        ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                } else {
                    // المفروض هنا يخصم ويبيدل بئا
                    $qtn->qtn = $newQ + $saved['qtn'];
                    $qtn->save();
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في مخزن ' . StoreModel::find($basic->storeId)->namear);
            }
        }
        $saved->delete();
        return response()->json([
            'status' => 200,
            'id' => $id,
        ]);
    }

    public function destroy($id)
    {
        $product = ItemsAssembly::find($id);
        $list = ItemsAssemblyList::where('assembly_id', $id)->get();
        $invoice = SavedInvoices::where('item_id', $product->itemId)->first();

        if ($invoice) {
            return redirect()
                ->back()
                ->with('success', ' لا يمكن حضف الحركة لارتباطها بحركات ');
        }
        if ($product) {
            // دي للبروسيس
            if (count($list) > 0) {
                foreach ($list as $item) {
                    $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                        ->where('unitId', $item['unitId'])
                        ->first();
                    $MainItem = Items::find($itemCheck2->itemId);
                    if ($MainItem->item_type != 3) {
                        $qtn = QtnItems::where('item_id', $itemCheck2['itemId'])
                            ->where('store_id', $product->storeId)
                            ->first();
                        $smal = Itemslist::where('itemId', $item['itemId'])
                            ->where('small_unit', '=', 1)
                            ->get()
                            ->first();

                        $newQ = 0;
                        if ($qtn) {
                            if ($itemCheck2['small_unit'] == 1) {
                                $newQ = $qtn->qtn;
                            } else {
                                $newQ = $smal['packing'] * $qtn->qtn;
                            }
                            if ($newQ < $item['qtn']) {
                                return redirect()
                                    ->back()
                                    ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear);
                            } else {
                                // المفروض هنا يخصم ويبيدل بئا
                                $qtn->qtn = $newQ + $item['qtn'];
                                $qtn->save();
                            }
                        } else {
                            return redirect()
                                ->back()
                                ->with('error', ' لا يوجد رصيد للصنف ' . $MainItem->namear . ' في مخزن ' . StoreModel::find($product->storeId)->namear);
                        }
                    }
                }
            }

            $bas = Itemslist::where('itemId', $product->itemId)
                ->where('small_unit', '=', 1)
                ->first();
            $check = QtnItems::where('item_id', $product->itemId)
                ->where('store_id', $product->storeId)
                ->first();
            if ($check->qtn > 0) {
                $check->qtn = $check->qtn - $product['qtn'];
                $check->save();
            } else {
                $check->delete();
            }

            if (count($list) > 0) {
                foreach ($list as $item) {
                    $item->delete();
                }
            }
            $product->delete();
        }

        return redirect()
            ->route('assembly.index')
            ->with('msg', 'Successfuly Deleted');
    }
}
