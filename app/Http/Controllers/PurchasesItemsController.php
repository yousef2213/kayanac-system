<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\Items;
use App\Purchases;
use App\PurchasesList;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use PDF;

class PurchasesItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $savedSalles = PurchasesList::all();
        $Invoices = Purchases::all();
        $customers = Customers::all();
        $categorys = CategoryItems::all();
        $items = Items::all();
        $branches = Branches::all();
        $company = Compaines::get()->first();

        return view('PurchasesItems.index')
            ->with('savedSalles', $savedSalles)
            ->with('Invoices', $Invoices)
            ->with('customers', $customers)
            ->with('items', $items)
            ->with('branches', $branches)
            ->with('company', $company)
            ->with('categorys', $categorys);
    }

    public function FilterItemsReports(Request $request)
    {
        if ($request->branch == 'all' && $request->customer == 'all') {
            $orders = Purchases::whereBetween('created_at', [
                $request->from,
                $request->to,
            ])->get();
        } elseif ($request->branch == 'all' && $request->customer != 'all') {
            $orders = Purchases::where('supplier', (int) $request->customer)
                ->whereBetween('created_at', [$request->from, $request->to])
                ->get();
            return $orders;
        } elseif ($request->customer == 'all' && $request->branch != 'all') {
            $orders = Purchases::where('branchId', (int) $request->branch)
                ->whereBetween('created_at', [$request->from, $request->to])
                ->get();
        } elseif ($request->branch != 'all' && $request->customer == 'all') {
            $orders = Purchases::where('branchId', (int) $request->branch)
                ->whereBetween('created_at', [$request->from, $request->to])
                ->get();
        } elseif ($request->branch != 'all' && $request->customer != 'all') {
            $orders = Purchases::where('branchId', (int) $request->branch)
                ->where('supplier', (int) $request->customer)
                ->whereBetween('created_at', [$request->from, $request->to])
                ->get();
        } else {
            $orders = Purchases::where('branchId', (int) $request->branch)
                ->where('supplier', (int) $request->customer)
                ->whereBetween('created_at', [$request->from, $request->to])
                ->get();
        }

        if ($request->item == 'all' && $request->category == 'all') {
            $saved = PurchasesList::all();
        } elseif ($request->category == 'all' && $request->item != 'all') {
            $saved = PurchasesList::where('itemId', $request->item)->get();
        } elseif ($request->item != 'all' && $request->category == 'all') {
            $saved = PurchasesList::where('itemId', $request->item)->get();
        } elseif ($request->item != 'all' && $request->category != 'all') {
            $saved = PurchasesList::where('itemId', $request->item)->get();
        } else {
            $saved = PurchasesList::all();
        }

        $units = Unit::all();
        $items = [];
        foreach ($orders as $order) {
            foreach ($saved as $save) {
                if ($save->purchasesId == $order->id) {
                    $items[] = $save;
                }
            }
        }

        if (count($items) > 0) {
            foreach ($items as $value) {
                $value->namear = Items::find($value->itemId)->namear;
            }
        }
        return response()->json([
            'items' => $items,
            'units' => $units,
        ]);
    }

    public function ReportPurchase()
    {
        $savedSalles = PurchasesList::all();
        $Invoices = PurchasesList::all();
        $customers = Customers::all();
        return view('Purchases.ReportPurchase')
            ->with('savedSalles', $savedSalles)
            ->with('Invoices', $Invoices)
            ->with('customers', $customers);
    }

    public function FilterItems(Request $request)
    {
        $orders = Purchases::whereBetween('created_at', [
            $request->from,
            $request->to,
        ])->get();
        $Invoices = PurchasesList::get();
        $customers = Supplier::all();
        $InvoicesDetails = [];

        foreach ($orders as $order) {
            foreach ($Invoices as $invoicesave) {
                if ($invoicesave->purchasesId == $order->id) {
                    $InvoicesDetails[] = $invoicesave;
                }
            }
        }

        if (count($InvoicesDetails) > 0) {
            foreach ($InvoicesDetails as $value) {
                $value->namear = Items::find($value->itemId)->namear;
            }
        }
        return response()->json([
            'InvoicesDetails' => $InvoicesDetails,
            'orders' => $orders,
            'customers' => $customers,
        ]);
    }

    public function generatePDFItems(Request $request)
    {
        // return $request;
        // $units = Unit::all();
        $id = 2;
        // $data = [
        //     'orders' => $request->data,
        //     'from' => $request->from,
        //     'to' => $request->to,
        //     'netTotal' => $request->netTotal,
        //     'units' => $units,
        //     'priceAfterTaxVal' => $request->priceAfterTaxVal,
        //     'totalTaxRate' => $request->ntotalTaxRateetTotal,
        // ];

        // $pdf = PDF::loadView('PdfPurchase');

        // return $pdf->download('Shift-.pdf');
        $pdf = PDF::loadView('PurchasesItems.Pdf', compact('id'));

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function createPdf(Request $request)
    {
        $list = json_decode($request->data[0], true);
        // return $request;
        $data = [
            'orders' => $list,
            'netTotal' => $request->netTotal,
            'priceAfterTaxVal' => $request->priceAfterTax,
            'totalDiscountRate' => $request->totalDiscountRate,
            'totalDiscountVal' => $request->totalDiscountVal,
            'totalTaxRate' => $request->totalTaxRate,
        ];
        $pdf = PDF::loadView('PurchasesItems.Pdf', $data);
        $pdf->download('ItemsReport - Purchases.pdf');
        return redirect()->back();
    }
}
