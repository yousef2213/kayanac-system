<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\Customers;
use App\Invoices;
use App\Items;
use App\PrinterSetting;
use App\RefUser;
use App\SavedInvoices;
use App\Shift;
use App\StoreModel;
use App\Unit;
use App\User;
use App\Versions;
use Illuminate\Http\Request;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Artisan;
use PDF;

use Carbon\Carbon;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $company = Compaines::find(1);
        $generatedString =   GenerateQrCode::fromArray([
            new Seller($company->companyNameAr),
            new TaxNumber($company->taxNum),
            new InvoiceDate(Carbon::now()->toDateTimeString()),
            new InvoiceTotalAmount("520"),
            new InvoiceTaxAmount("15.6")
        ])->render();

        $Items = Items::all();
        $stores = StoreModel::all();
        $branches = Branches::all();
        $users = User::all();

        // $ref = RefUser::all()->first();

        $customers = Customers::paginate(10);
        // return view('customers.index')
        return view('index')
            ->with('Items', $Items)
            ->with('customers', $customers)
            ->with('stores', $stores)
            ->with('users', $users)
            ->with('generatedString', $generatedString)
            ->with('branches', $branches);
    }

    public function FilterDate(Request $request)
    {
        $orders = Invoices::where('status', '!=', '2')
            ->whereBetween('created_at', [$request->from, $request->to])
            ->get();
        $customers = Customers::all();
        return response()->json([
            'orders' => $orders,
            'customers' => $customers,
        ]);
    }

    public function generatePDF($id)
    {
        $shift = Shift::find($id);
        $orders = Invoices::whereBetween('created_at', [
            $shift->openDate,
            $shift->closeDate,
        ])
            ->where('status', '!=', '2')
            ->get();
        $Invoices = SavedInvoices::get();
        $customers = Customers::all();
        $units = Unit::all();
        $InvoicesDetails = [];
        $PaymentTotal = 0;
        $taxValue = 0;
        foreach ($orders as $order) {
            foreach ($Invoices as $invoicesave) {
                if ($invoicesave->invoiceId == $order->id) {
                    if ($invoicesave->priceWithTax == '1') {
                        $invoicesave->TaxVal =
                            (($invoicesave->price / "1.$invoicesave->taxRate") *
                                $invoicesave->taxRate) /
                            100;
                    } else {
                        $invoicesave->TaxVal =
                            ($invoicesave->price * $invoicesave->taxRate) / 100;
                    }
                    $PaymentTotal += $invoicesave->total;
                    $taxValue += $invoicesave->TaxVal;
                    $InvoicesDetails[] = $invoicesave;
                }
            }
        }
        $InvoicesDetails = collect($InvoicesDetails);
        $InvoicesDetails->each(function ($item) {
            $item->unit_name = Unit::find($item->unit_id)->namear;
        });
        // return $InvoicesDetails;
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'InvoicesDetails' => $InvoicesDetails,
            'PaymentTotal' => $PaymentTotal,
            'customers' => $customers,
            'orders' => $orders,
            'units' => $units,
            'id' => $id,
            'taxValue' => $taxValue,
        ];
        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('Shift-' . $id . '.pdf');
    }

    public function generatePDFItems(Request $request)
    {
        $units = Unit::all();

        $data = [
            'orders' => $request->data,
            'from' => $request->from,
            'to' => $request->to,
            'netTotal' => $request->netTotal,
            'units' => $units,
            'priceAfterTaxVal' => $request->priceAfterTaxVal,
            'totalTaxRate' => $request->ntotalTaxRateetTotal,
        ];

        $pdf = PDF::loadView('ReportsPDF', $data);

        return $pdf->download('Reports.pdf');
    }

    public function FilterItems(Request $request)
    {
        // $orders = Invoices::where('status', '!=', '2')
        //     ->whereBetween('created_at', [$request->from, $request->to])
        //     ->get();

        $orders = Invoices::where('status', '!=', '3')->whereBetween('created_at', [$request->from, $request->to])
            ->get();
        $company = Compaines::all()->first();


        $Invoices = SavedInvoices::get();
        $InvoicesDetails = [];
        $orders->each(function ($item) {
            $item->customer = Customers::find($item->customerId)->name;
            if ($item->status == 1) {
                $item->payment = "كاش";
            }
            if ($item->status == 2) {
                $item->payment = "اجل";
            }
            if ($item->status == 4) {
                $item->payment = "توصيل";
            }
            if ($item->status == 10) {
                $item->payment = $item->status;
            }
        });
        foreach ($orders as $order) {
            foreach ($Invoices as $invoicesave) {
                if ($invoicesave->invoiceId == $order->id) {
                    $InvoicesDetails[] = $invoicesave;
                }
            }
        }
        return response()->json([
            'InvoicesDetails' => $InvoicesDetails,
            'orders' => $orders,
            'company' => $company,
        ]);
    }

    public function FilterItemsReports(Request $request)
    {
        if ($request->branch == 'all' && $request->customer == 'all') {
            $orders = Invoices::where('status', '!=', '3')->whereBetween('created_at', [$request->from, $request->to])->get();
        } elseif ($request->branch == 'all' && $request->customer != 'all') {
            $orders = Invoices::where('status', '!=', '3')->where('customerId', (int) $request->customer)->whereBetween('created_at', [$request->from, $request->to])->get();
        } elseif ($request->customer == 'all' && $request->branch != 'all') {
            $orders = Invoices::where('status', '!=', '3')->where('branchId', (int) $request->branch)->whereBetween('created_at', [$request->from, $request->to])->get();
        } elseif ($request->branch != 'all' && $request->customer == 'all') {
            $orders = Invoices::where('status', '!=', '3')->where('branchId', (int) $request->branch)->whereBetween('created_at', [$request->from, $request->to])->get();
        } elseif ($request->branch != 'all' && $request->customer != 'all') {
            $orders = Invoices::where('status', '!=', '3')->where('branchId', (int) $request->branch)->where('customerId', (int) $request->customer)->whereBetween('created_at', [$request->from, $request->to])->get();
        } else {
            $orders = Invoices::where('status', '!=', '3')->where('branchId', (int) $request->branch)->where('customerId', (int) $request->customer)->whereBetween('created_at', [$request->from, $request->to])->get();
        }

        if ($request->item == 'all' && $request->category == 'all') {
            $saved = SavedInvoices::all();
        } elseif ($request->item == 'all' && $request->category != 'all') {
            $saved = SavedInvoices::where('groupItem', $request->category)->get();
        } elseif ($request->category == 'all' && $request->item != 'all') {
            $saved = SavedInvoices::where('itemId', $request->item)->get();
        } elseif ($request->item != 'all' && $request->category == 'all') {
            $saved = SavedInvoices::where('itemId', $request->item)->get();
        } elseif ($request->item != 'all' && $request->category != 'all') {
            $saved = SavedInvoices::where('itemId', $request->item)->where('groupItem', $request->category)->get();
        } else {
            $saved = SavedInvoices::all();
        }

        $units = Unit::all();

        $items = [];
        foreach ($orders as $order) {
            foreach ($saved as $save) {
                if ($save->invoiceId == $order->id) {
                    $items[] = $save;
                }
            }
        }
        collect($items)->each(function ($item) {
            $item->unit_name = Unit::find($item->unit_id)->namear;
        });
        return response()->json([
            'items' => $items,
        ]);
    }

    public function printerSetting()
    {
        $company = Compaines::get()->first();
        $setting = PrinterSetting::first();
        return view('setting.index')
            ->with('setting', $setting)
            ->with('company', $company);
    }

    public function setting()
    {
        return view('version.index');
    }

    public function zipCreater()
    {
        $zip = new ZipArchive();
        $last_version = Versions::orderBy('id', 'desc')->first();
        $countVersion = 0.1;
        if ($last_version) {
            $current_version = $last_version->version + $countVersion;
        } else {
            $current_version = $countVersion;
        }
        $fileName = 'version-' . $current_version . '.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) == true) {
            $files = File::files(public_path('myfiles'));
            foreach ($files as $key => $value) {
                $rev = basename($value);
                $zip->addFile($value, $rev);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }

    public function upload(Request $request)
    {
        if ($request->has('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = 'version-4' . '.' . $extension;

            $request
                ->file('file')
                ->move(storage_path('versions'), $fileNameToStore);
        }

        $last_version = Versions::orderBy('id', 'desc')->first();
        $countVersion = 0.1;
        if ($last_version) {
            $current_version = $last_version->version + $countVersion;
        } else {
            $current_version = $countVersion;
        }

        $name = 'version-' . $current_version . '.zip';
        $version = Versions::create();
        $version->version = $current_version;
        $version->zip_file = $name;
        $version->active = 1;
        $version->save();
        return redirect()
            ->route('home')
            ->with('msg', 'Successfully Update Version');
    }

    public function extractFiles()
    {
        $version = Versions::get()->last();
        if ($version) {
            if ($version->active == 1) {
                // return response()->json([
                //     "file" => $version
                // ]);
                $filename = storage_path('versions/' . $version->zip_file);
                $za = new ZipArchive();
                $folder = $filename;
                $za->open($folder);
                $za->extractTo(base_path());
                $za->close();
                $version->active = 0;
                $version->save();
                return response()->json([
                    'msg' => ' تم تحديث الاصدار بنجاح',
                    'status' => 1,
                ]);
            } else {
                return response()->json([
                    'msg' => 'لا يوجد اصدار جديد',
                    'status' => 2,
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'لا يوجد اصدار جديد',
                'status' => 2,
            ]);
        }
    }

    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        $items = Invoices::whereYear('created_at', $year)
            ->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        $amount = 0;
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount += $item->netTotal;
                $m = intval($month);
                isset($result[$m])
                    ? ($result[$m] += $amount)
                    : ($result[$m] = $amount);
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = !empty($result[$i])
                ? number_format((float) $result[$i], 2, '.', '')
                : 0.0;
        }
        return $data;
    }

    public function BackUp()
    {
        $cmd = 'php ' . base_path() . '/artisan backup:run';
        $export = shell_exec($cmd);
        return redirect()->back()->with('backUp', 'Successfully backed up');
    }

    public function ReportsPrint()
    {
        return view('reports.itemsReports');
    }
    public function ClearCash()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:cache');


        return  redirect()->back()->with('msg', "Cleared Cash");
    }
}
