<?php

namespace App\Http\Controllers;

use App\Casher;
use App\CasherList;
use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\Invoices;
use App\Items;
use App\Itemslist;
use App\Shift;
use App\StoreModel;
use App\TablesModal;
use App\Unit;
use App\User;
use Illuminate\Http\Request;

class CasherController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customers::all();
        $company = Compaines::all()->first();
        if ($company->restaurant != 0) {
            return redirect()->route('pos');
        }
        $items = Items::all();
        $CatrgoryItems = CategoryItems::all();
        $units = Unit::all();
        $tables = TablesModal::all();
        $shiftOpening = Shift::orderBy('id', 'desc')->first();
        $itemList = Itemslist::all();
        $stores = StoreModel::all();
        $itemList->each(function ($item) {
            $item->item_name = Items::find($item['itemId'])->namear;
            $item->unit_name = Unit::find($item['unitId'])->namear;
        });

        return view('Casher.index')
            ->with('customers', $customers)
            ->with('stores', $stores)
            ->with('itemList', $itemList)
            ->with('items', $items)
            ->with('CatrgoryItems', $CatrgoryItems)
            ->with('units', $units)
            ->with('shiftOpening', $shiftOpening)
            ->with('tables', $tables)
            ->with('company', $company);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'netTotal' => 'required',
            'list' => 'required',
        ]);
        // Check
        if ($request->status == 10) {
            $total = $request->cash + $request->masterCard + $request->credit + $request->visa;
            if ($total < $request->netTotal || $total > $request->netTotal) {
                return response()->json([
                    'msg' => 'صافي الفاتورة لا يساوي اجمالي الدفعات',
                    'status' => 201,
                ]);
            }
        }
        // create casher invoice
        $casher = Invoices::create([
            'netTotal' => $request->netTotal,
            'total' => $request->netTotal,
            'status' => $request->status,
            'customer_id' => $request->customerId,
        ]);
        if ($request->cash) {
            $casher->cash = $request->cash;
            $casher->save();
        }
        if ($request->visa) {
            $casher->visa = $request->visa;
            $casher->save();
        }
        if ($request->masterCard) {
            $casher->masterCard = $request->masterCard;
            $casher->save();
        }
        if ($request->credit) {
            $casher->credit = $request->credit;
            $casher->save();
        }
        if ($request->status == 11) {
            $casher->credit = $request->netTotal;
            $casher->status = 10;
            $casher->save();
        }
        if ($casher) {
            if (count($request->list) > 0) {
                foreach ($request->list as $item) {
                    CasherList::create([
                        'casher_id' => $casher->id,
                        'item_id' => $item['itemId'],
                        'item_name' => $item['name'],
                        'price_after_tax' => $item['priceafterTax'],
                        'tax_value' => $item['TaxVal'],
                        'unit_id' => $item['unitId'],
                        'customer_id' => $request->customerId,
                    ]);
                }
            }
        }

        return response()->json([
            'msg' => 'invoice saved',
            'status' => 200,
            'casher_id' => $casher->id,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }



    function printInvoice()
    {
        return view('Casher.print_voice');
    }
}
