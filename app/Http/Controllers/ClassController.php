<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Items;
use App\ItemsAssembly;
use App\ItemsAssemblyList;
use App\Itemslist;
use App\PermissionAdd;
use App\PermissionAddList;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCategoryCard');
    }

    public function index()
    {
        $items = Items::all();
        $items->each(function ($item) {
            if (Unit::find($item->catId)) {
                $item->unit_name = Unit::find($item->catId)->namear;
            }
            $item->unit_id = $item->catId;
        });
        return view('ItemMovement.index')->with('items', $items);
    }

    public function itemFilter(Request $request)
    {
        $list = PermissionAddList::where('itemId', $request->item_id)->get();
        $listCollection = ItemsAssemblyList::where('itemId', $request->item_id)->get();
        $listCollection2 = ItemsAssembly::where('itemId', $request->item_id)->get();
        // return $list;

        $listCollection->each(function ($item) {
            $item->source = "تجميع الاصناف";
            $item->source_num = ItemsAssembly::find($item->assembly_id)->id;
            $item->storeId = ItemsAssembly::find($item->assembly_id)->storeId;
            $item->date = ItemsAssembly::find($item->assembly_id)->startDate;
            $item->store_name = StoreModel::find(ItemsAssembly::find($item->assembly_id)->storeId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->price = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->get()->first()->av_price;
            $item->total = $item->price * $item->qtn;
            $item->nettotal = $item->price * $item->qtn;
        });
        $listCollection2->each(function ($item) {
            $item->source = "تجميع الاصناف";
            $item->source_num = $item->id;
            $item->storeId = $item->storeId;
            $item->date = $item->startDate;
            $item->store_name = StoreModel::find($item->storeId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->price = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->get()->first()->av_price;
            $item->total = $item->price * $item->qtn;
            $item->nettotal = $item->price * $item->qtn;
        });

        $list->each(function ($item) {
            $item->source = PermissionAdd::find($item->source_num)->source;
            $item->date = PermissionAdd::find($item->source_num)->dateInvoice;
            $item->branchId = PermissionAdd::find($item->source_num)->branchId;
            $item->branch_name = Branches::find(PermissionAdd::find($item->source_num)->branchId)->namear;
            $item->store_name = StoreModel::find(1)->namear;
            // $item->store_name = StoreModel::find($item->storeId)->namear;
            if (Unit::find($item->unitId)) {
                $item->unit_name = Unit::find($item->unitId)->namear;
            }
        });

        $list2 = PermissionCashingList::where('itemId', $request->item_id)->get();
        $list2->each(function ($item) {
            $item->source = PermissionCashing::find($item->source_num)->source;
            $item->date = PermissionCashing::find($item->source_num)->dateInvoice;
            $item->branchId = PermissionCashing::find($item->source_num)->branchId;
            $item->branch_name = Branches::find(PermissionCashing::find($item->source_num)->branchId)->namear;
            $item->store_name = StoreModel::find(1)->namear;
            // $item->store_name = StoreModel::find($item->storeId)->namear;
            if (Unit::find($item->unitId)) {
                $item->unit_name = Unit::find($item->unitId)->namear;
            }
        });


        // new

        return response()->json([
            'list' => $list,
            'list2' => $list2,
            'item' => $list2,
            'listCollection' => $listCollection,
            'listCollection2' => $listCollection2,
        ]);
    }
}
