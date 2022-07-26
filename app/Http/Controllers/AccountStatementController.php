<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Branches;
use App\CostCenters;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\OpeningBalanceAccounts;
use App\OpeningBalanceAccountsList;
use App\Supplier;
use App\Traits\GetAccounts;
use Illuminate\Http\Request;

class AccountStatementController extends Controller
{
    use GetAccounts;
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }
    public function index()
    {
        $branches = Branches::all();
        $accounts = $this->accounts();
        $costCenters = CostCenters::where('child', '=', 1)->get();


        // return Supplier::all();
        return view('accountStatement.index')->with('branches', $branches)->with('accounts', $accounts)->with('costCenters', $costCenters);
    }

    public function getData(Request $request)
    {

        $OpeningBalance = OpeningBalanceAccountsList::where('account_id', $request->accountId)->get();
        $OpeningBalance->each(function ($item) {
            $item->description = "رصيد افتتاحي";
            $item->branshId = OpeningBalanceAccounts::find($item->invoice_id)->branchId;
            $item->branshName = Branches::find(OpeningBalanceAccounts::find($item->invoice_id)->branchId)->namear;
            $item->date = OpeningBalanceAccounts::find($item->invoice_id)->date;
        });
        if ($request->accountId != "all") {
            if ($request->cost_center) {
                $invoicesList = DailyRestrictionsList::where('account_id', $request->accountId)->where('cost_center', $request->cost_center)->get();
            } else {
                $invoicesList = DailyRestrictionsList::where('account_id', $request->accountId)->get();
            }
        }
        if ($request->accountId == "all") {
            if ($request->cost_center) {
                $invoicesList = DailyRestrictionsList::where('cost_center', $request->cost_center)->get();
            } else {
                $invoicesList = DailyRestrictionsList::all();
            }
        }

        $invoicesList->each(function ($item) {
            $item->branshId = DailyRestrictions::find($item->invoice_id)->branshId;
            $item->source_name = DailyRestrictions::find($item->invoice_id)->source_name;
            $item->numDailty = DailyRestrictions::find($item->invoice_id)->id;
            $item->source = DailyRestrictions::find($item->invoice_id)->source;
            $item->branshName = Branches::find(DailyRestrictions::find($item->invoice_id)->branshId)->namear;
            $item->date = DailyRestrictions::find($item->invoice_id)->date;
        });
        // return $invoicesList;
        $di = collect(collect($OpeningBalance)->merge($invoicesList))->whereBetween('date', [$request->from, $request->to]);
        return $di->values()->toArray();
    }

    public function print()
    {
        return view('accountStatement.print');
    }
}
