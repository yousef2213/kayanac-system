<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeLoginControll extends Controller {
    public function Login(Request $request){
         $request->validate([
            'pass' => 'required',
        ]);
        $user = User::where('pass', $request->pass)->first();
        $credentials = $user->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
        return Auth;

        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }
}
