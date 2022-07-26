<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\Invoices;
use App\Items;
use App\SavedInvoices;
use App\Unit;
use Illuminate\Http\Request;
use PDF;


class ItemsSallesSavedController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permision:TsReportsItemsSals');
        $this->middleware('active_permision');
    }


    public function index()
    {
        $savedSalles = SavedInvoices::all();
        $Invoices = Invoices::all();
        $customers = Customers::all();
        $categorys = CategoryItems::all();
        $items = Items::all();
        $branches = Branches::all();
        $company = Compaines::get()->first();

        return view('ItemsSalesSaved.index')
            ->with('savedSalles', $savedSalles)
            ->with('Invoices', $Invoices)
            ->with('customers', $customers)
            ->with('items', $items)
            ->with('branches', $branches)
            ->with('company', $company)
            ->with('categorys', $categorys);
    }


    public function generatePDFItems(Request $request)
    {



        $list = json_decode($request->data[0], true);
        $data = [
            'orders' => $list,
            'netTotal' => $request->netTotal,
            'priceAfterTaxVal' => $request->priceAfterTax,
            'totalDiscountRate' => $request->totalDiscountRate,
            'totalDiscountVal' => 0,
            'totalTaxRate' => $request->totalTaxRate,
        ];
        $pdf = PDF::loadView('ItemsSalesSaved.Pdf', $data);
        $pdf->download('ItemsReport - Salles.pdf');
        return redirect()->back();

        //

        $data = [
            'orders' => $request->data,
            'from' => $request->from,
            'to' => $request->to,
            'netTotal' => $request->netTotal,
            // 'units' => $units,
            'priceAfterTaxVal' => $request->priceAfterTaxVal,
            'totalTaxRate' => $request->ntotalTaxRateetTotal,
        ];

        $pdf = PDF::loadView('ReportsPDF', $data);

        return $pdf->download('Reports.pdf');
    }
}
