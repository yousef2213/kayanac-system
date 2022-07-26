<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Branches;
use App\CostCenters;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\Traits\GetAccounts;
use Illuminate\Http\Request;

class FinancialCenterController extends Controller
{
    use GetAccounts;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $branches = Branches::all();
        return view('FinancialCenter.index')
            ->with('costCenters', $costCenters)
            ->with('branches', $branches);
    }

    public function Filter(Request $request)
    {
        $incomes = Accounts::where('parentId', 3)->where('child', 1)->get();
        $outs = Accounts::where('parentId', 4)->where('child', 1)->get();
        $incomes->each(function ($acc) {
            if (!$acc->name) {
                $acc->name = $acc->namear;
            }
            if (!$acc->account_id) {
                $acc->account_id = $acc->id;
            }
        });
        $outs->each(function ($acc) {
            if (!$acc->name) {
                $acc->name = $acc->namear;
            }
            if (!$acc->account_id) {
                $acc->account_id = $acc->id;
            }
        });
        $incomes->each(function ($row) {
            $row->parent_name = Accounts::find(3)->account_name;
            $row->parent_id = Accounts::find(3)->account_id;
        });
        $outs->each(function ($row) {
            $row->parent_name = Accounts::find(4)->account_name;
            $row->parent_id = Accounts::find(4)->account_id;
        });


        if ($request->from != '' && $request->to != '') {
            // if ($request->costCenters != "") {
            //     $data = DailyRestrictions::whereBetween('date', [$request->from, $request->to])->get();
            //     $list1 = [];
            //     foreach ($data as $item) {
            //         $items = DailyRestrictionsList::where('invoice_id', $item->id)->where('cost_center', $request->costCenters)->get();
            //         foreach ($items as $ele) {
            //             $list1[] = $ele;
            //         }
            //     }
            //     $incomesList = [];
            //     foreach ($list1 as $daily) {
            //         foreach ($incomes as $income) {
            //             if ($income->account_id == $daily->account_id) {
            //                 $daily['parent_name'] = Accounts::find(3)->namear;
            //                 $daily['parent_id'] = Accounts::find(3)->id;
            //                 $incomesList[] = $daily;
            //             }
            //         }
            //     }
            //     $outsList = [];
            //     foreach ($list1 as $daily) {
            //         foreach ($outs as $out) {
            //             if ($out->account_id == $daily->account_id) {
            //                 $daily['parent_name'] = Accounts::find(4)->namear;
            //                 $daily['parent_id'] = Accounts::find(4)->id;
            //                 $outsList[] = $daily;
            //             }
            //         }
            //     }
            //     return response()->json([
            //         'list1' => $incomesList,
            //         'list2' => $outsList,
            //     ]);
            // } else { // done
            $data = DailyRestrictions::whereBetween('date', [$request->from, $request->to])->get();
            $list = [];
            foreach ($data as $item) {
                $items = DailyRestrictionsList::where('invoice_id', $item->id)->get();
                foreach ($items as $ele) {
                    $list[] = $ele;
                }
            }

            $incomesList = [];
            $listDaily = DailyRestrictions::whereBetween('date', [$request->from, $request->to])->get();
            foreach ($list as $daily) {
                foreach ($incomes as $income) {
                    if ($income->account_id == $daily->account_id) {
                        $daily['parent_name'] = Accounts::find(3)->namear;
                        $daily['parent_id'] = Accounts::find(3)->id;
                        $incomesList[] = $daily;
                    }
                }
            }
            $outsList = [];
            foreach ($list as $daily) {
                foreach ($outs as $out) {
                    if ($out->account_id == $daily->account_id) {
                        $daily['parent_name'] = Accounts::find(4)->namear;
                        $daily['parent_id'] = Accounts::find(4)->id;
                        $outsList[] = $daily;
                    }
                }
            }
            return response()->json([
                'list1' => $incomesList,
                'list2' => $outsList,
                'first' => $list,
            ]);
            // }
        } // done
        else { // done
            // if ($request->costCenters == "") {
            $incomesList = [];
            $listDaily = DailyRestrictionsList::all();
            foreach ($listDaily as $daily) {
                foreach ($incomes as $income) {
                    if ($income->account_id == $daily->account_id) {
                        $daily['parent_name'] = Accounts::find(3)->namear;
                        $daily['parent_id'] = Accounts::find(3)->id;
                        $incomesList[] = $daily;
                    }
                }
            }
            $outsList = [];
            foreach ($listDaily as $daily) {
                foreach ($outs as $out) {
                    if ($out->account_id == $daily->account_id) {
                        $daily['parent_name'] = Accounts::find(4)->namear;
                        $daily['parent_id'] = Accounts::find(4)->id;
                        $outsList[] = $daily;
                    }
                }
            }
            return response()->json([
                'list1' => $incomesList,
                'list2' => $outsList,
                'first' => $listDaily,
            ]);
            // } else {
            //     $incomesList = [];
            //     $listDaily = DailyRestrictionsList::all();
            //     foreach ($listDaily as $daily) {
            //         foreach ($incomes as $income) {
            //             if ($income->account_id == $daily->account_id) {
            //                 $daily['parent_name'] = Accounts::find(3)->namear;
            //                 $daily['parent_id'] = Accounts::find(3)->id;
            //                 $incomesList[] = $daily;
            //             }
            //         }
            //     }
            //     $outsList = [];
            //     $listDaily =  DailyRestrictionsList::where('cost_center', $request->costCenters)->get();

            //     foreach ($listDaily as $daily) {
            //         foreach ($outs as $out) {
            //             if ($out->account_id == $daily->account_id) {
            //                 $daily['parent_name'] = Accounts::find(4)->namear;
            //                 $daily['parent_id'] = Accounts::find(4)->id;
            //                 $outsList[] = $daily;
            //             }
            //         }
            //     }
            //     return response()->json([
            //         'list1' => $listDaily,
            //         'list2' => $outsList,
            //     ]);
            // }
        }
    }
}
