<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CostCenters;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\OpeningBalanceAccounts;
use App\OpeningBalanceAccountsList;
use App\Traits\GetAccounts;
use Illuminate\Http\Request;

class CostCentersReports extends Controller
{
    use GetAccounts;
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $accounts = $this->accounts();
        $branches = Branches::all();
        return view('costCenterReports.index')
            ->with('costCenters', $costCenters)
            ->with('accounts', $accounts)
            ->with('branches', $branches);
    }

    public function Filter(Request $request)
    {
        // return $request;

        if ($request->from != '' && $request->to != '') {

            if ($request->account == 0) {

                if ($request->costCenters != "") {

                    $data = DailyRestrictions::where('cost_center', $request->costCenters)->whereBetween('date', [$request->from, $request->to])->get();
                    $list1 = [];
                    foreach ($data as $item) {
                        $items = DailyRestrictionsList::where('invoice_id', $item->id)->get();
                        foreach ($items as $ele) {
                            $list1[] = $ele;
                        }
                    }
                    collect($list1)->each(function ($item) {
                        $item->type = 2;
                    });
                    $data2 = OpeningBalanceAccounts::whereBetween('date', [$request->from, $request->to])->get();
                    $list2 = [];
                    foreach ($data2 as $item2) {
                        $items = OpeningBalanceAccountsList::where('invoice_id', $item2->id)->get();
                        foreach ($items as $ele) {
                            $list2[] = $ele;
                        }
                    }
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                } else {
                    $data = DailyRestrictions::whereBetween('date', [$request->from, $request->to])->get();
                    $list1 = [];
                    foreach ($data as $item) {
                        $items = DailyRestrictionsList::where('invoice_id', $item->id)->get();
                        foreach ($items as $ele) {
                            $list1[] = $ele;
                        }
                    }
                    collect($list1)->each(function ($item) {
                        $item->type = 2;
                    });
                    $data2 = OpeningBalanceAccounts::whereBetween('date', [$request->from, $request->to])->get();
                    $list2 = [];
                    foreach ($data2 as $item2) {
                        $items = OpeningBalanceAccountsList::where('invoice_id', $item2->id)->get();
                        foreach ($items as $ele) {
                            $list2[] = $ele;
                        }
                    }
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                }
            } else {

                if ($request->costCenters != "") {
                    $data = DailyRestrictions::whereBetween('date', [$request->from, $request->to])->get();
                    $list1 = [];
                    foreach ($data as $item) {
                        $items = DailyRestrictionsList::where('invoice_id', $item->id)
                            ->where('account_id', $request->account)
                            ->where('cost_center', $request->costCenters)
                            ->get();
                        foreach ($items as $ele) {
                            $list1[] = $ele;
                        }
                    }
                    collect($list1)->each(function ($item) {
                        $item->type = 2;
                    });
                    $data2 = OpeningBalanceAccounts::whereBetween('date', [$request->from, $request->to])->get();

                    $list2 = [];
                    foreach ($data2 as $item2) {
                        $items = OpeningBalanceAccountsList::where('invoice_id', $item2->id)->get();
                        foreach ($items as $ele) {
                            $list2[] = $ele;
                        }
                    }
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                }
            }
        } else {



            if ($request->account == 0) {

                if ($request->costCenters == "") {
                    $list1 = DailyRestrictionsList::all();
                    $list1->each(function ($item) {
                        $item->type = 2;
                    });
                    $list2 = OpeningBalanceAccountsList::all();
                    $list2->each(function ($item) {
                        $item->type = 1;
                    });
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                } else {
                    $list1 = DailyRestrictionsList::where('cost_center', $request->costCenters)->get();
                    $list1->each(function ($item) {
                        $item->type = 2;
                    });
                    $list2 = OpeningBalanceAccountsList::all();
                    $list2->each(function ($item) {
                        $item->type = 1;
                    });
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                }
            } else {

                if ($request->costCenters == "") {
                    $list1 = DailyRestrictionsList::where('account_id', $request->account)->get();
                    $list1->each(function ($item) {
                        $item->type = 2;
                    });
                    $list2 = OpeningBalanceAccountsList::where('account_id', $request->account)->get();
                    $list2->each(function ($item) {
                        $item->type = 1;
                    });
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                } else {


                    $list1 = DailyRestrictionsList::where('account_id', $request->account)->where('cost_center', $request->costCenters)->get();
                    $list1->each(function ($item) {
                        $item->type = 2;
                    });
                    $list2 = OpeningBalanceAccountsList::where('account_id', $request->account)->get();
                    $list2->each(function ($item) {
                        $item->type = 1;
                    });
                    return response()->json([
                        'list1' => $list1,
                        'list2' => $list2,
                    ]);
                }
            }
        }
    }
}
