<?php

namespace App\Http\Controllers;

use App\Branches;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\OpeningBalanceAccounts;
use App\OpeningBalanceAccountsList;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $branches = Branches::all();
        return view('budget.index')->with('branches', $branches);
    }

    public function bagetFilter(Request $request)
    {

        if ($request->from != '' && $request->to != '') {
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
            $list2 = [];
            return response()->json([
                'list1' => $list1,
                'list2' => $list2,
            ]);
        } else {
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
        }
    }
}
