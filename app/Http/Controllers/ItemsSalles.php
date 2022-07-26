<?php

namespace App\Http\Controllers;

use App\Compaines;
use App\Customers;
use App\Invoices;
use App\SavedInvoices;
use Illuminate\Http\Request;

class ItemsSalles extends Controller {


    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permision:TsInvoiceSales');
        $this->middleware('active_permision');
    }


    public function index() {
        $savedSalles = SavedInvoices::all();
        $company = Compaines::all()->first();
        $Invoices = Invoices::all();
        return view('ItemsSales.index')
                ->with('savedSalles', $savedSalles)
                ->with('company', $company)
                ->with('Invoices', $Invoices);
    }

}
