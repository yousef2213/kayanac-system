<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CategoryItems;
use App\Items;
use App\ItemsAssembly;
use App\ItemsAssemblyList;
use App\Itemslist;
use App\OpeningBalanceList;
use App\PermissionAdd;
use App\PermissionAddList;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\QtnItems;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class StockValuation extends Controller
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
        $branches = Branches::all();
        $stores = StoreModel::all();
        $groups = CategoryItems::all();
        $items->each(function ($item) {
            if (Unit::find($item->catId)) {
                $item->unit_name = Unit::find($item->catId)->namear;
            }
            $item->unit_id = $item->catId;
        });
        return view('StockValuation.index')
        ->with('branches', $branches)
        ->with('groups', $groups)
        ->with('stores', $stores)
        ->with('items', $items);
    }

    public function getItemsByCategory($catId)
    {
        $items = Items::where('catId', $catId)->where('item_type','!=',3)->get();
        return $items;
    }

    public function StockFilter(Request $request)
    {
        $items = [];
        if($request->groupId[0] == "yousef"){
            $allGroups= CategoryItems::all();
            foreach ($allGroups as $cat) {
                $isItems = Items::where('catId', $cat->id)->where('item_type','!=',3)->get();
                if($isItems){
                    foreach ($isItems as $value) {
                        $items[] = $value;
                    }
                }
            }
        }else {
            foreach ($request->groupId as $cat) {
                $isItems = Items::where('catId', $cat)->where('item_type','!=',3)->get();
                if($isItems){
                    foreach ($isItems as $value) {
                        $items[] = $value;
                    }
                }
            }
        }


        $data = [];
        if($items){
           foreach ($items as $item) {
               $isItem = QtnItems::where('item_id', $item->id)->where('store_id', $request->storeId)->get();
               if($isItem){
                   foreach ($isItem as $value) {
                       $data[] = $value;
                   }
               }
           }
        }

       collect($data)->each(function($item){
           $item->item_name = Items::find($item->item_id)->namear;
           $item->catId = Items::find($item->item_id)->catId;
           $item->cat_name = CategoryItems::find($item->catId)->namear;
           $item->unit_name = Unit::find($item->unit_id)->namear;
           $item->store_name = StoreModel::find($item->store_id)->namear;
           $item->av_price = Itemslist::where('itemId',$item->item_id)->first()->av_price;
            if($item->av_price == 0) {
                $isTrue = OpeningBalanceList::where('unitId', $item->unit_id)->where('itemId', $item->item_id)->first();
                if($isTrue){
                    $item->av_price = OpeningBalanceList::where('unitId', $item->unit_id)->where('itemId', $item->item_id)->first()->price;
                }else {
                    $item->av_price = 0;
                }
            }
       });
       return $data;


    }

}
