<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('name', $request->name)->first();
        if(!$user){
            return response()->json([
                'status' => 400,
                'isSuccess' => false,
                "message" => "user not found"
            ]);
        }
        if(Hash::check($request->password, $user->password)){
            $user = collect($user)->except('password');
            return response()->json($user);
        }
        return response()->json([
            'status' => 400,
            'isSuccess' => false,
            "message" => "wrong password ...!"
        ]);
    }


}
