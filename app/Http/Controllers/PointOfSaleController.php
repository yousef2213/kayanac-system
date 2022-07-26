<?php

namespace App\Http\Controllers;

use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\Items;
use App\Itemslist;
use App\TablesModal;
use App\Unit;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PointOfSaleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }
    public function index()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $customers = Customers::all();
        $company = Compaines::find(1);
        $items = Items::all();
        $CatrgoryItems = CategoryItems::select("name" . $lang . ' as name', 'id', 'img')->get();
        $units = Unit::all();
        $tables = TablesModal::all();
        $itemList = Itemslist::all();


        return view('PointOfSale.index')
            ->with('customers', $customers)
            ->with('itemList', $itemList)
            ->with('items', $items)
            ->with("CatrgoryItems", $CatrgoryItems)
            ->with("units", $units)
            ->with('tables', $tables)
            ->with('company', $company);
    }

    public function ItemDirect($id, $unitId)
    {
        $item = Items::find($id);
        $list = Itemslist::where('itemId', $item->id)->where('unitId', $unitId)->get();
        $units = Unit::all();

        return response()->json([
            "item" => $item,
            "list" => $list,
            "units" => $units
        ]);
        // return $list;
    }

    public function ItemByBarCode($barcode)
    {
        $list = Itemslist::where('barcode', $barcode)->first();
        if (!$list) {
            $list = [];
            $item = [];
        } else {
            $item = Items::find($list->itemId);
        }
        $units = Unit::all();
        return response()->json([
            "item" => $item,
            "list" => $list,
            "units" => $units
        ]);
    }
}
