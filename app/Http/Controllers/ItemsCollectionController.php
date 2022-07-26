<?php

namespace App\Http\Controllers;

use App\Items;
use App\ItemsCollection;
use App\ItemsCollectionList;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\QtnItems;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsCollectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $itemCollection = ItemsCollection::all();
        $itemCollection->each(function ($item) {
            $item->item_name = Items::find($item->itemId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
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
        return view('ItemsCollection.index')
                ->with('orders', $orders)
                ->with('itemCollection', $itemCollection);
    }

    public function create()
    {
        $items = Items::where('item_type', 2)->get();
        $itemsCreate = Items::where('item_type', '!=', 2)->get();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        return view('ItemsCollection.create')->with('items', $items)->with('itemsCreate', $itemsCreate)->with('units', $units)->with('itemsList', $itemsList);
    }


    public function getItemCollection($id)
    {
        $item = Items::find($id);
        $list = Itemslist::where('itemId', $id)->get();
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

        if (!$request->itemId) {
            return redirect()->back()->with('msg', 'تاكد من  البيانات');
        }
        if (!$request->unitId) {
            return redirect()->back()->with('msg', 'تاكد من  البيانات');
        }
        $list = json_decode($request->list[0], true);
        if (count($list) <= 0) {
            return redirect()->back()->with('msg', 'تاكد من اضافة البيانات');
        }

        $id = 1;
        $lastId = ItemsCollection::all()->last();
        if ($lastId) {
            $id = $lastId->id + 1;
        }
        $item = ItemsCollection::create([
            'id' => $id,
            'itemId' => $request->itemId,
            'unitId' => $request->unitId,
        ]);

        foreach ($list as $item) {
            ItemsCollectionList::create([
                'collection_id' => $id,
                'itemId' => $item['itemId'],
                'unitId' => $item['unitId'],
                'qtn' => $item['qtn'],
            ]);
        }

        return redirect()->route('items-collection.index')->with('msg', 'تم اضافة تكوين الصنف بنجاح');
    }

    public function edit($id)
    {
        $items = Items::where('item_type', 2)->get();
        $itemsCreate = Items::where('item_type', '!=', 2)->get();

        $item = ItemsCollection::find($id);
        $itemsList = Itemslist::where('itemId',  $item->itemId)->get();
        $itemsList->each(function($row) {
            $row->unit_name = Unit::find($row->unitId)->namear;
        });
        // return $itemsList;

        $list = ItemsCollectionList::where('collection_id', $id)->get();
        $list->each(function ($item) {
            $item->item_name = Items::find($item->itemId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->units = Itemslist::where('itemId', $item->itemId)->get();
            $item->units->each(function ($row) {
                $row->unit_name = Unit::find($row->unitId)->namear;
            });
        });
        return view('ItemsCollection.edit')->with('item', $item)->with('list', $list)->with('items', $items)->with('itemsCreate', $itemsCreate)->with('itemsList', $itemsList);
    }


    public function update(Request $request, $id)
    {
        if (!$request->itemId) {
            return redirect()->back()->with('msg', 'تاكد من  البيانات');
        }
        if (!$request->unitId) {
            return redirect()->back()->with('msg', 'تاكد من  البيانات');
        }
        $list = json_decode($request->list[0], true);
        if (count($list) <= 0) {
            return redirect()->back()->with('msg', 'تاكد من اضافة البيانات');
        }

        $item = ItemsCollection::find($id);
        if ($request->itemId) {
            $item->itemId = $request->itemId;
            $item->save();
        }
        if (!$request->unitId) {
            $item->unitId = $request->unitId;
            $item->save();
        }
        foreach ($list as $item) {
            if ($item['isNew']) {
                ItemsCollectionList::create([
                    'collection_id' => $id,
                    'itemId' => $item['itemId'],
                    'unitId' => $item['unitId'],
                    'qtn' => $item['qtn'],
                ]);
            } else {
                $row = ItemsCollectionList::find($item['id']);
                if (isset($item['unitId']) && $item['unitId'] != "" && $item['unitId'] != 'null') {
                    $row->unitId = $item['unitId'];
                    $row->save();
                }

                if ($item['itemId']) {
                    $row->itemId = $item['itemId'];
                    $row->save();
                }
                if ($item['qtn']) {
                    $row->qtn = $item['qtn'];
                    $row->save();
                }
                $row->save();
            }
        }

        return redirect()->route('items-collection.index')->with('msg', 'تم التعديل بنجاح');
    }


    public function deleteRow($id)
    {
        $saved = ItemsCollectionList::find($id);
        $saved->delete();
        return response()->json([
            "status" => 200,
            'id' => $id
        ]);
    }

    public function destroy($id)
    {
        $item = ItemsCollection::find($id);
        $list = ItemsCollectionList::where('collection_id', $id)->get();

        if (count($list) > 0) {
            foreach ($list as $row) {
                $row->delete();
            }
        }
        if ($item) {
            $item->delete();
        }

        return redirect()->route('items-collection.index')->with('msg', 'تم حذف تكوين الصنف بنجاح');
    }
}
