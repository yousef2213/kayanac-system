<?php

namespace App\Http\Controllers;

use App\Refrence;
use App\RefrenceItems;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
    }

    public function CreateRef(Request $request)
    {
        if (isset($request->parent) && isset($request->name)) {
            RefrenceItems::create([
                'parent_id' => $request->parent,
                'name' => $request->name,
            ]);
            return response()->json([
                'msg' => "Successfuly Created",
                'parent' => $request->parent,
                'status' => 200
            ]);
        } else {
            return response()->json([
                'msg' => "تاكد من البيانات",
                'status' => 201
            ]);
        }

        return $request;
    }
    public function DeleteRef($name)
    {
        return $name;
    }
    public function company()
    {
        return "Company";
    }

    public function UsersPermisions()
    {
        $users = User::all();
        return view('users.permision')->with('users', $users);
    }

}
