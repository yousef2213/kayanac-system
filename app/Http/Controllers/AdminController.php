<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    public function index() {

        if(Auth::user()){
            return view('index');
        }else {
            return redirect()->route('login');
        }

    }


}
