<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CategoryItems;
use App\Items;
use App\ItemsAssembly;
use App\ItemsAssemblyList;
use App\ItemsCollection;
use App\ItemsCollectionList;
use App\Itemslist;
use App\PermissionAdd;
use App\PermissionAddList;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\QtnItems;
use App\StoreModel;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemsBalances extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsCategoryCard');
    }

    public function index()
    {
        // return Carbon::now()->toDateTimeString();
        $items = Items::where('item_type','!=',3)->get();
        $branches = Branches::all();
        $stores = StoreModel::all();
        $groups = CategoryItems::all();
        $items->each(function ($item) {
            if (Unit::find($item->catId)) {
                $item->unit_name = Unit::find($item->catId)->namear;
            }
            $item->unit_id = $item->catId;
        });


        return view('ItemsBalances.index')
        ->with('branches', $branches)
        ->with('groups', $groups)
        ->with('stores', $stores)
        ->with('items', $items);
    }

    public function itemFilter(Request $request)
    {

        $qtn = [];

         if($request->itemId){
            foreach ($request->itemId as $itemId) {
                $isItem = QtnItems::where('item_id', $itemId)->get();
                if($isItem){
                    foreach ($isItem as $value) {
                        $qtn[] = $value;
                    }
                }
            }
         }

        collect($qtn)->each(function($item){
            $item->item_name = Items::find($item->item_id)->namear;
            $item->unit_name = Unit::find($item->unit_id)->namear;
            $item->store_name = StoreModel::find($item->store_id)->namear;
        });
        return $qtn;
    }
}
