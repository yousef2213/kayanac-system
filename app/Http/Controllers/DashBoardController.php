<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $users = User::all();
        return view('dashboardUsers.index')->with('users', $users);
    }


    public function active($id)
    {
        $user = User::find($id);
        return response()->json([
            "status" => 200,
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        return response()->json([
            "status" => 200,
            'data' => $user
        ]);
    }
}
