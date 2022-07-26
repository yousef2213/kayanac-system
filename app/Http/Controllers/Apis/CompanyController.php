<?php

namespace App\Http\Controllers\Apis;

use App\Compaines;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    public function company()
    {
        $company = Compaines::all()->first();
        return response()->json([
            "data" => $company
        ]);
    }
}
