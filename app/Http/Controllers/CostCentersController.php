<?php

namespace App\Http\Controllers;

use App\CostCenters;
use App\OrderPages;
use App\Powers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostCentersController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }


    public function index()
    {
        $groups = CostCenters::all();
        $groups->each(function ($item) {
            if ($item->group1 != 0) {
                $item->nameGroup1 = CostCenters::where('id', $item->group1)->first()->namear;
            } else {
                $item->nameGroup1 = "";
            }

            if ($item->group2 != 0) {
                $item->nameGroup2 = CostCenters::where('id', $item->group2)->first()->namear;
            } else {
                $item->nameGroup2 = "";
            }
            if ($item->group3 != 0) {
                $item->nameGroup3 = CostCenters::where('id', $item->group3)->first()->namear;
            } else {
                $item->nameGroup3 = "";
            }
            if ($item->group4 != 0) {
                $item->nameGroup4 = CostCenters::where('id', $item->group4)->first()->namear;
            } else {
                $item->nameGroup4 = "";
            }
        });
        // return $groups;


        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCostCenters" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsCostCenters" )->first();
        }
        return view('cost_centers.index')->with('orders', $orders)->with('groups', $groups);
    }
    public function create()
    {
        $groups = CostCenters::where('parent', '=', 1)->where('group1', '=', 0)->where('group2', '=', 0)->where('group3', '=', 0)->where('group4', '=', 0)->get();
        return view('cost_centers.create')->with('groups', $groups);
    }

    public function getGroups($id)
    {
        if ($id == 986869) {
            $id = 0;
        }

        return CostCenters::where('parent', '=', 1)->where('group1', '=', $id)->where('group2', '=', 0)->where('group3', '=', 0)->where('group4', '=', 0)->get();
    }
    public function getGroups2($id1, $id2)
    {
        if ($id1 == 986869) {
            $id1 = 0;
        }
        if ($id2 == 986869) {
            $id2 = 0;
        }
        return CostCenters::where('group1', '=', $id1)
            ->where('group2', '=', $id2)
            ->where('group3', '=', 0)
            ->where('group4', '=', 0)
            ->where('parent', '=', 1)
            ->get();
    }

    public function getGroups3($id1, $id2, $id3)
    {
        // return 'group 1 is ' . $id1 . " " . 'group 2 is ' . " " . $id2 . 'group 3 is ' . " " . $id3;
        if ($id1 == 986869) {
            $id1 = 0;
        }
        if ($id2 == 986869) {
            $id2 = 0;
        }
        if ($id3 == 986869) {
            $id3 = 0;
        }
        return CostCenters::where('group1', '=', $id1)
            ->where('group2', '=', $id2)
            ->where('group3', '=', $id3)
            ->where('group4', '=', 0)
            ->where('parent', '=', 1)
            ->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namear' => 'required',
            'nameen' => 'required',
        ]);
        $parent = 0;
        $child = 0;
        if ($request->group_type == 1) {
            $parent = 1;
            $child = 0;
        }
        if ($request->group_type == 0) {
            $parent = 0;
            $child = 1;
        }
        if ($request->group1 == 986869) {
            $request->group1 = 0;
        }
        if ($request->group2 == 986869) {
            $request->group2 = 0;
        }
        if ($request->group3 == 986869) {
            $request->group3 = 0;
        }
        if ($request->group4 == 986869) {
            $request->group4 = 0;
        }
        $last = CostCenters::all()->last();

        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }
        CostCenters::create([
            'num' => $new_id,
            'namear' => $request->namear,
            'nameen' => $request->nameen,
            'child' => $child,
            'parent' => $parent,
            'group1' => $request->group1,
            'group2' => $request->group2,
            'group3' => $request->group3,
            'group4' => $request->group4,
        ]);
        return redirect()->route('cost_centers.index')->with('msg', "Successfully Added");
    }



    public function destroy($id)
    {
        $cost = CostCenters::find($id);
        if ($cost->child == 1) {
            $cost->delete();
            return redirect()->route('cost_centers.index')->with('msg', 'Successfully Deleted');
        }

        if ($cost->parent == 1) {
            $cost1 = CostCenters::where('group1', $id)->get();
            if (count($cost1) != 0) {
                return redirect()->back()->with('error', 'يوجد مراكز تكلفة مرتبطة بمركز التكلفة');
            }
            $cost2 = CostCenters::where('group2', $id)->get();
            if (count($cost2) != 0) {
                return redirect()->back()->with('error', 'يوجد مراكز تكلفة مرتبطة بمركز التكلفة');
            }
            $cost3 = CostCenters::where('group3', $id)->get();
            if (count($cost3) != 0) {
                return redirect()->back()->with('error', 'يوجد مراكز تكلفة مرتبطة بمركز التكلفة');
            }
        }

        $cost->delete();
        return redirect()->route('cost_centers.index')->with('msg', 'Successfully Deleted');
    }
}
