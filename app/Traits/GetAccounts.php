<?php

namespace App\Traits;

use App\Accounts;
use App\Supplier;
use App\Customers;
use App\Employees;

trait GetAccounts
{
    function accounts()
    {
        $suppliers = Supplier::all();
        $customers = Customers::all();
        $employees = Employees::all();
        $another_account = Accounts::where('child', 1)->get();

        $accounts = collect($customers)->merge($suppliers);
        $accountResultFirst = collect($accounts)->merge($another_account);
        $accountResult = collect($accountResultFirst)->merge($employees);
        $accountResult->each(function ($acc) {
            if (!$acc->name) {
                $acc->name = $acc->namear;
            }
            if (!$acc->account_id) {
                $acc->account_id = $acc->id;
            }
        });
        return $accountResult;
    }
}
