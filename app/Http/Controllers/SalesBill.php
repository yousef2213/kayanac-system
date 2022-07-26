<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Compaines;
use App\CostCenters;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\Employees;
use App\FiscalYears;
use App\Invoices;
use App\Items;
use App\QtnItems;
use App\Itemslist;
use App\OpeningBalanceAccountsList;
use App\OrderPages;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\Powers;
use App\ReturnedSallesInvoice;
use App\ReturnedSallesInvoiceList;
use App\SavedInvoices;
use App\StoreModel;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesBill extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsInvoiceSales');
    }

    public function index()
    {
        $savedSalles = SavedInvoices::all();
        $Invoices = Invoices::all();
        $Invoices->each(function ($invoice) {
            $invoice->customer_name = Customers::find($invoice->customerId)->name;
        });
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsInvoiceSales" )->first();
        if(!$orders) {
                $columns = \Schema::getColumnListing('powers');
                $loginUser = Auth::user();
                $data['user_id'] = $loginUser->id;
                $power = Powers::create($data);
                if($loginUser->type == 3){
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            $power[$column] = 1;
                            $power->save();
                        }
                    }
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 1,
                                "add" => 1,
                                "edit" => 1,
                                "delete" => 1,
                            ]);
                        }
                    }
                }
                else {
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 0,
                                "add" => 0,
                                "edit" => 0,
                                "delete" => 0,
                            ]);
                        }
                    }
                }
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsInvoiceSales" )->first();
        }
        return view('SalesBill.index')
            ->with('orders', $orders)
            ->with('Invoices', $Invoices)
            ->with('savedSalles', $savedSalles);
    }

    public function create()
    {
        $company = Compaines::all()->first();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $branches = Branches::all();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $employees = Employees::where('occupation', 'مندوب')->get();
        $purchaseId = Invoices::orderBy('id', 'DESC')->first();
        if ($purchaseId) {
            $id = Invoices::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $id = 1;
        }

        $customers->each(function($el){
            $el->OpeningBalance = OpeningBalanceAccountsList::where('account_id', $el->account_id)->get();
            $el->invoicesList = DailyRestrictionsList::where('account_id', $el->account_id)->get();
            $el->data = collect(collect($el->OpeningBalance)->merge($el->invoicesList));
            $totaling = 0;
            foreach ($el->data as $item) {
                if ($item->source != 0) {
                    if ($item->debtor != 0) {
                        $totaling += +$item->debtor;
                    }
                    if ($item->creditor != 0) {
                        $totaling -= $item->creditor;
                    }
                }
            }
            $el->balance = $totaling;

        });

        return view('SalesBill.create')
            ->with('costCenters', $costCenters)
            ->with('customers', $customers)
            ->with('company', $company)
            ->with('stores', $stores)
            ->with('id', $id)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('employees', $employees)
            ->with('branches', $branches);
    }

    public function store(Request $request)
    {
        // return $request;
        $acc = Customers::find($request->customerId);
        $list = json_decode($request->list[0], true);
        $netTotalList = 0;
        $totals = 0;
        $average_total = 0;
        $taxs = 0;

        if (count($list) > 0) {
            foreach ($list as $item) {
                if (!isset($item['itemId'])) {
                    return redirect()->back()->with('error', 'من فضلك تاكد من البيانات');
                }
                if (!isset($item['unitId'])) {
                    return redirect()->back()->with('error', 'من فضلك تاكد من البيانات');
                }
                if (!isset($item['storeId'])) {
                    return redirect()->back()->with('error', 'من فضلك تاكد من البيانات');
                }
                $itemCheck = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                if (!$itemCheck) {
                    return redirect()
                        ->back()
                        ->with('error', 'لا توجد هذة الوحدة للصنف ');
                }
                $diss = 0;
                if (isset($item['discount']) && $item['discount'] != '') {
                    $diss = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $netTotalList += $nettotal;
                $totals += $total;
                $taxs += $value;
            }
        } else {
            return redirect()->back()->with('error', 'من فضلك تاكد من البيانات');
        }
        $newList = [];

        if (count($list) > 0) {
            foreach ($list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $newList[] = $item;
            }
        }
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $average_total += $item['av_price'];

                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $check = $this->getQtn($item['itemId'], $item['unitId'], $item['storeId']);
                    if ($check) {
                        if ($check->qtn < $item['newQ']) {
                            return redirect()
                                ->back()
                                ->with('error', 'لا يوجد رصيد للصنف');
                        }
                    } else {
                        return redirect()
                            ->back()
                            ->with('error', 'لا يوجد رصيد للصنف');
                    }
                }
            }
        }

        $fiscal_year =  FiscalYears::all()->first();

        $id = 1;
        $last_invoice = Invoices::all()->last();
        if ($last_invoice) {
            $id = $last_invoice->id + 1;
        }
        $invoice = Invoices::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'branchId' => $request->branchId,
            'status' => $request->payment,
            'netTotal' => $netTotalList,
            'customerId' => $request->customerId,
            'delegateId' => $request->delegateId,
        ]);


        if ($request->dateInvoice && $request->dateInvoice != "") {
            $invoice->dateInvoice = $request->dateInvoice;
            $invoice->save();
        }
        if ($request->duedate && $request->duedate != "") {
            $invoice->duedate = $request->duedate;
            $invoice->save();
        }

        if ($request->taxSourceValue) {
            $invoice->netTotal = $netTotalList - $request->taxSourceValue;
            $invoice->save();
        }
        if ($request->taxSource) {
            $invoice->taxSource = $request->taxSource;
            $invoice->save();
        }

        // +++++++++
        $id_permision = 1;
        $last_permision = PermissionCashing::all()->last();
        if ($last_permision) {
            $id_permision = $last_permision->id + 1;
        }
        // اذن صرف


        $permission = PermissionCashing::create([
            'id' => $id_permision,
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $invoice->id,
            "fiscal_year" => $fiscal_year->code,
            'source' => 'مبيعات',
            'customerId' => $request->customerId,
            'netTotal' => $netTotalList,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storedId' => 1,
        ]);
        if ($request->dateInvoice != "") {
            $permission->dateInvoice = $request->dateInvoice;
            $permission->save();
        }
        if ($request->costCenter) {
            $invoice->cost_center = $request->costCenter;
            $invoice->save();
        }

        if (count($newList) > 0) {
            foreach ($newList as $item) {


                $diss = 0;
                $description = null;
                if (isset($item['discount']) && $item['discount'] != '') {
                    $diss = $item['discount'];
                }
                if (isset($item['description'])) {
                    $description = $item['description'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($diss * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                $addedN = '';
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                    $addedN = $item['added'];
                } else {
                    $value = 0;
                    $addedN = 0;
                }
                $nettotal = $total + $value;
                $itemDetails = Items::find($item['itemId']);
                SavedInvoices::create([
                    'invoiceId' => $invoice->id,
                    'customer_id' => $request->customerId,
                    'storeId' => $item['storeId'],
                    'item_id' => $item['itemId'], // --
                    'unit_id' => $item['unitId'], // --
                    'qtn' => $item['qtn'], // --
                    'price' => $item['price'], // --
                    'discountRate' => $diss, // --
                    'discountValue' => $discountValue, // --
                    'price' => $item['price'], // --
                    'item_name' => $itemDetails->namear, // --
                    'nettotal' => $nettotal, // --
                    'rate' => $addedN, // --
                    'total' => $totalBefore, // --
                    'value' => $value,
                    'description' => $description,
                ]);



                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);

                if ($MainItem->item_type != 3) {

                    // اذن صرف
                    PermissionCashingList::create([
                        'invoiceId' => $invoice->id,
                        'source_num' => $permission->id,
                        'itemId' => $item['itemId'],
                        'unitId' => $item['unitId'],
                        'qtn' => $item['qtn'],
                        'price' => $item['price'],
                        'discountRate' => $diss,
                        'discountValue' => $discountValue,
                        'total' => $totalBefore,
                        'value' => $value,
                        'rate' => $addedN,
                        'nettotal' => $nettotal,
                    ]);


                    $qtnN = QtnItems::where('item_id', $item['itemId'])
                        ->where('store_id', $item['storeId'])
                        ->first();
                    $qtnN->qtn = $qtnN->qtn - $item['newQ'] + 0;
                    $qtnN->save();
                }
            }
        }


        $perList = PermissionCashingList::where("source_num", $permission->id)->get();
        if (count($perList) <= 0) {
            $permission->delete();
        }


        $this->createCuff($request, $acc, $netTotalList, $invoice, $taxs, $average_total, $totals);

        return redirect()->route('salesBill.index');
    }

    public function getQtn($item = 1, $unit = 1, $store)
    {
        $qtn = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();

        return $qtn;
    }

    // Done
    public function saveQtn($item, $unit, $store, $qtn)
    {
        $status = Itemslist::where('itemId', $item)
            ->where('unitId', $unit)
            ->first();
        $check = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();
        if ($check) {
            $check->qtn = $check->qtn + $status->packing * $qtn;
            $check->save();
        } else {
            QtnItems::create([
                'item_id' => $item,
                'unit_id' => $unit,
                'store_id' => $store,
                'qtn' => $status->packing * $qtn,
            ]);
        }
    }

    // انشاء القيود
    public function createCuff($data, $account, $netTotalList = 0, $invoice, $taxs, $average_total, $totals)
    {
        $fiscal_year = FiscalYears::find(1);
        $last = DailyRestrictions::all()->last();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }
        // Cuff Account

        $val  = 0;
        if ($data->taxSourceValue) {
            $val = $data->taxSourceValue;
        }

        $idIn = DailyRestrictions::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'document' => '',
            'description' => '',
            'branshId' => $data->branchId,
            'source' => $invoice->id,
            'source_name' => 'مبيعات',
            'creditor' => $netTotalList - $val,
            'debtor' => $netTotalList - $val,
        ]);

        if ($data->payment == 1) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotalList - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totals,
                'description' => '',
            ]);
            if ($data->costCenter) {
                $SalesDail->cost_center = $data->costCenter;
                $SalesDail->save();
            }

            if ($data->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => $val,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }

            if ($average_total != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 27,
                    'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                    'debtor' => $average_total,
                    'creditor' => 0,
                    'description' => '',
                ]);
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 12,
                    'account_name' => 'مخزون المخزن الرئيسى',
                    'debtor' => 0,
                    'creditor' => $average_total,
                    'description' => '',
                ]);
            }

            //
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => $netTotalList - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $netTotalList - $val,
                'description' => '',
            ]);
        }
        if ($data->payment == 2) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotalList - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totals,
                'description' => '',
            ]);
            if ($data->costCenter) {
                $SalesDail->cost_center = $data->costCenter;
                $SalesDail->save();
            }
            if ($data->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => $val,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }
            if ($average_total != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 27,
                    'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                    'debtor' => $average_total,
                    'creditor' => 0,
                    'description' => '',
                ]);
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 12,
                    'account_name' => 'مخزون المخزن الرئيسى',
                    'debtor' => 0,
                    'creditor' => $average_total,
                    'description' => '',
                ]);
            }
        }
        return $idIn;
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $costCenters = CostCenters::where('child', '=', 1)->get();
        $customers = Customers::all();
        $stores = StoreModel::all();
        $items = Items::all();
        $itemsList = Itemslist::all();
        $units = Unit::all();
        $invocie = Invoices::find($id);
        $company = Compaines::all()->first();
        $invoiceList = SavedInvoices::where('invoiceId', $invocie->id)->get();
        // return $invocie;
        return view('SalesBill.edit')
            ->with('invocie', $invocie)
            ->with('costCenters', $costCenters)
            ->with('company', $company)
            ->with('invoiceList', $invoiceList)
            ->with('customers', $customers)
            ->with('stores', $stores)
            ->with('items', $items)
            ->with('itemsList', $itemsList)
            ->with('units', $units)
            ->with('branches', $branches);
    }

    public function update(Request $request, $id)
    {
        $list = json_decode($request->list[0], true);
        $lastTotal = 0;
        $totalBeforCalculation = 0;
        $average_total = 0;
        $newList = [];
        $taxs = 0;
        $totals = 0;
        // return $list;
        if (count($list) > 0) {
            foreach ($list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                $MainItem = Items::find($status->itemId);
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $average_total += $item['av_price'];
                $newList[] = $item;
            }
        }
        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $average_total += $item['av_price'];
                $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();
                $MainItem = Items::find($itemCheck2->itemId);
                if ($MainItem->item_type != 3) {
                    $check = $this->getQtn($item['itemId'], $item['unitId'], $item['storeId']);
                    if ($check) {
                        if ($check->qtn < $item['newQ']) {
                            return redirect()
                                ->back()
                                ->with('error', 'لا يوجد رصيد للصنف');
                        }
                    } else {
                        return redirect()
                            ->back()
                            ->with('error', 'لا يوجد رصيد للصنف');
                    }
                }
            }
        }
        // return $newList;
        $last = PermissionCashing::all()->last();
        $new_id = 1;
        if ($last) {
            $new_id = $last->num + 1;
        }

        $invoice = Invoices::find($id);
        if ($request->costCenter && $request->costCenter != "") {
            $invoice->cost_center = $request->costCenter;
            $invoice->save();
        }
        $fiscal_year = FiscalYears::all()->first();
        $id_permision = 1;
        if ($request->taxSource) {
            $invoice->taxSource = $request->taxSource;
            $invoice->save();
        }

        $per = PermissionCashing::where("source", 'مبيعات')->where("source_num", $id)->first();
        if ($per) {
            $perList = PermissionCashingList::where("source_num", $per->id)->get();
            $per->delete();
            foreach ($perList as $permision) {
                $permision->delete();
            }
        }


        $last_permision = PermissionCashing::all()->last();
        if ($last_permision) {
            $id_permision = $last_permision->id + 1;
        }

        $permission = PermissionCashing::create([
            'id' => $id_permision,
            'fiscal_year' => $fiscal_year->code,
            'source_num' => $invoice->id,
            'num' => $new_id,
            'source' => 'مبيعات',
            'customerId' => $request->customerId,
            'netTotal' => $totalBeforCalculation,
            'payment' => $request->payment,
            'branchId' => $request->branchId,
            'storedId' => 1,
        ]);
        if (!empty($newList)) {
            if (count($newList) > 0) {
                foreach ($newList as $item) {
                    $disco = 0;
                    if (isset($item['discount']) && $item['discount'] != 0) {
                        $disco = $item['discount'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($disco * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = 0;
                    $addedN = '';
                    if (isset($item['added'])) {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $totalBeforCalculation += $nettotal;
                    // اذن صرف
                    $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                        ->where('unitId', $item['unitId'])
                        ->first();
                    $MainItem = Items::find($itemCheck2->itemId);
                    if ($MainItem->item_type != 3) {
                        PermissionCashingList::create([
                            'invoiceId' => $invoice->id,
                            'source_num' => $permission->id,
                            'itemId' => $item['itemId'],
                            'unitId' => $item['unitId'],
                            'qtn' => $item['qtn'],
                            'price' => $item['price'],
                            'discountRate' => $disco,
                            'discountValue' => $discountValue,
                            'total' => $totalBefore,
                            'value' => $value,
                            'rate' => $addedN,
                            'nettotal' => $nettotal,
                        ]);
                    }
                }
            }
        }

        $permission->netTotal = $totalBeforCalculation;
        if ($request->taxSourceValue) {
            $invoice->netTotal = $totalBeforCalculation - $request->taxSourceValue;
            $invoice->save();
        }
        $permission->save();




        if (count($newList) > 0) {
            foreach ($newList as $item) {
                $dis = 0;
                if (isset($item['discount']) && $item['discount'] != 0) {
                    $dis = $item['discount'];
                }
                $totalBefore = $item['qtn'] * $item['price'];
                $discountValue = ($dis * $totalBefore) / 100;
                $total = $item['qtn'] * $item['price'] - $discountValue;
                $value = 0;
                if (isset($item['added'])) {
                    $value = ($total * $item['added']) / 100;
                } elseif (isset($item['rate'])) {
                    $value = ($total * $item['rate']) / 100;
                } else {
                    $value = 0;
                }
                $nettotal = $total + $value;
                $lastTotal += $nettotal;
                $taxs += $value;
                $totals += $total;
            }
        }

        if ($request->payment == '1') {
            $request->payment = 3;
        }

        if (count($newList) > 0) {
            foreach ($newList as $item) {
                if ($item['isNew'] == true) {
                    $disco = 0;
                    if (isset($item['discount']) && $item['discount'] != 0) {
                        $disco = $item['discount'];
                    }
                    $totalBefore = $item['qtn'] * $item['price'];
                    $discountValue = ($disco * $totalBefore) / 100;
                    $total = $item['qtn'] * $item['price'] - $discountValue;
                    $value = 0;
                    $addedN = '';
                    if (isset($item['added']) && $item['added'] != "") {
                        $value = ($total * $item['added']) / 100;
                        $addedN = $item['added'];
                    } else {
                        $value = 0;
                        $addedN = 0;
                    }
                    $nettotal = $total + $value;
                    $itemDetails = Items::find($item['itemId']);
                    $description = null;
                    if (isset($item['description'])) {
                        $description = $item['description'];
                    }
                    SavedInvoices::create([
                        'invoiceId' => $invoice->id,
                        'customer_id' => $request->customerId,
                        'storeId' => $item['storeId'],
                        'item_id' => $item['itemId'], // --
                        'unit_id' => $item['unitId'], // --
                        'qtn' => $item['qtn'], // --
                        'price' => $item['price'], // --
                        'discountRate' => $disco, // --
                        'discountValue' => $discountValue, // --
                        'price' => $item['price'], // --
                        'item_name' => $itemDetails->namear, // --
                        'nettotal' => $nettotal, // --
                        'rate' => $addedN, // --
                        'total' => $totalBefore, // --
                        'value' => $value,
                        'description' => $description,
                    ]);
                    $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                        ->where('unitId', $item['unitId'])
                        ->first();
                    $MainItem = Items::find($itemCheck2->itemId);
                    if ($MainItem->item_type != 3) {
                        $qtnN = QtnItems::where('item_id', $item['itemId'])
                            ->where('store_id', $item['storeId'])
                            ->first();
                        $qtnN->qtn = $qtnN->qtn - $item['newQ'];
                        $qtnN->save();
                    }
                } else {
                    $itemUpdate = SavedInvoices::find($item['id']);
                    if ($item['storeId']) {
                        $itemUpdate->storeId = $item['storeId'];
                        $itemUpdate->save();
                    }
                    if ($item['itemId']) {
                        $itemUpdate->item_id = $item['itemId'];
                        $itemUpdate->save();
                    }
                    if ($item['unitId']) {
                        $itemUpdate->unit_id = $item['unitId'];
                        $itemUpdate->save();
                    }

                    if ($item['qtn'] && $item['price']) {
                        $old_qtn = $itemUpdate->qtn;
                        $new_qtn = $item['qtn'];
                        $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                            ->where('unitId', $item['unitId'])
                            ->first();
                        $MainItem = Items::find($itemCheck2->itemId);
                        if ($MainItem->item_type != 3) {
                            if ($new_qtn > $old_qtn) {
                                $between = $new_qtn - $old_qtn;
                                $qtnN = QtnItems::where('item_id', $item['itemId'])
                                    ->where('store_id', $item['storeId'])
                                    ->first();

                                $status = Itemslist::where('itemId', $item['itemId'])
                                    ->where('unitId', $item['unitId'])
                                    ->first();
                                $new_Qtn = $status->packing * $between;

                                $qtnN->qtn = $qtnN->qtn - $new_Qtn;
                                $qtnN->save();
                            }
                            if ($new_qtn < $old_qtn) {
                                $between = $old_qtn - $new_qtn;
                                $qtnN = QtnItems::where('item_id', $item['itemId'])
                                    ->where('store_id', $item['storeId'])
                                    ->first();

                                $status = Itemslist::where('itemId', $item['itemId'])
                                    ->where('unitId', $item['unitId'])
                                    ->first();
                                $new_Qtn = $status->packing * $between;

                                $qtnN->qtn = $qtnN->qtn + $new_Qtn;
                                $qtnN->save();
                            }
                        }

                        if ($item['qtn']) {
                            $itemUpdate->qtn = $item['qtn'];
                            $itemUpdate->save();
                        }
                        if ($item['price']) {
                            $itemUpdate->price = $item['price'];
                            $itemUpdate->save();
                        }

                        $dis = 0;
                        $ad = $itemUpdate->rate;
                        if (isset($item['discount']) && $item['discount'] != "") {
                            $dis = $item['discount'];
                        }
                        $totalBefore = $item['qtn'] * $item['price'];
                        $discountValue = ($dis * $totalBefore) / 100;
                        $total = $item['qtn'] * $item['price'] - $discountValue;
                        if (isset($item['added']) && $item['added'] != "") {
                            $itemUpdate->rate = $item['added'];
                            $itemUpdate->save();
                        }

                        $value = ($total * $ad) / 100;
                        $nettotal = $total + $value;
                        $itemUpdate->discountValue = $discountValue;
                        $itemUpdate->discountRate = $dis;
                        $itemUpdate->total = $total;
                        $itemUpdate->value = $value;
                        $itemUpdate->nettotal = $nettotal;
                        $itemUpdate->save();
                    }

                    // if (isset($item['discount']) && $item['discount'] != "") {
                    //     $itemUpdate->discountRate = $item['discount'];
                    //     $itemUpdate->save();
                    // }
                }
            }
        }
        $perList = PermissionCashingList::where("source_num", $permission->id)->get();
        if (count($perList) <= 0) {
            $permission->delete();
        }
        $invoice->customerId = $request->customerId;
        $invoice->status = $request->payment;
        $invoice->branchId = $request->branchId;
        $invoice->netTotal = $lastTotal - $request->taxSourceValue;
        $invoice->save();



        $cuu =  DailyRestrictions::where('source_name', 'مبيعات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();

        $cuu->debtor = $lastTotal - $request->taxSourceValue;
        $cuu->creditor = $lastTotal - $request->taxSourceValue;
        $cuu->save();
        if (count($cuuList) > 0) {
            foreach ($cuuList as $cuuItem) {
                $cuuItem->delete();
            }
        }
        $account = Customers::find($request->customerId);


        $val  = 0;
        if ($request->taxSourceValue) {
            $val = $request->taxSourceValue;
        }

        if ($request->payment == 1 || $request->payment == 3) {
            DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $lastTotal - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totals,
                'description' => '',
            ]);
            if ($request->costCenter) {
                $SalesDail->cost_center = $request->costCenter;
                $SalesDail->save();
            }

            if ($request->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => $val,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }

            if ($average_total != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 27,
                    'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                    'debtor' => $average_total,
                    'creditor' => 0,
                    'description' => '',
                ]);
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 12,
                    'account_name' => 'مخزون المخزن الرئيسى',
                    'debtor' => 0,
                    'creditor' => $average_total,
                    'description' => '',
                ]);
            }

            //
            DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => $lastTotal - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $lastTotal - $val,
                'description' => '',
            ]);
        } else {

            DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $lastTotal - $val,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $cuu->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totals,
                'description' => '',
            ]);
            if ($request->costCenter) {
                $SalesDail->cost_center = $request->costCenter;
                $SalesDail->save();
            }

            if ($request->taxSourceValue) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => $val,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            if ($taxs != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }

            if ($average_total != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 27,
                    'account_name' => 'تكلفة مبيعات المخزن الرئيسى',
                    'debtor' => $average_total,
                    'creditor' => 0,
                    'description' => '',
                ]);
                DailyRestrictionsList::create([
                    'invoice_id' => $cuu->id,
                    'account_id' => 12,
                    'account_name' => 'مخزون المخزن الرئيسى',
                    'debtor' => 0,
                    'creditor' => $average_total,
                    'description' => '',
                ]);
            }
        }

        $invoice->save();
        return redirect()->route('salesBill.index');
    }

    public function deleteRow($id)
    {
        $saved = SavedInvoices::find($id);
        $saved->delete();
        return response()->json([
            "status" => 200,
            'id' => $id
        ]);
    }

    public function destroy($id)
    {
        $per = PermissionCashing::where("source", 'مبيعات')->where("source_num", $id)->first();
        if ($per) {
            $perList = PermissionCashingList::where("source_num", $per->id)->get();
        }
        $delete = Invoices::findorFail($id);
        $cuu =  DailyRestrictions::where('source_name', 'مبيعات')->where('source', $id)->first();
        $cuuList = DailyRestrictionsList::where('invoice_id', $cuu->id)->get();
        $saved = SavedInvoices::where('invoiceId', $id)->get();
        foreach ($saved as $invoice) {
            $itemCheck2 = Itemslist::where('itemId', $invoice['item_id'])
                ->where('unitId', $invoice['unit_id'])
                ->first();
            $MainItem = Items::find($itemCheck2->itemId);

            if ($MainItem->item_type != 3) {
                $status = Itemslist::where('itemId', $invoice['item_id'])->where('unitId', $invoice['unit_id'])->first();
                $check = QtnItems::where('item_id',  $invoice['item_id'])->where('store_id',  $invoice['storeId'])->first();

                if ($check) {
                    $check->qtn = $check->qtn + ($status->packing  * $invoice['qtn'] + 0);
                    $check->save();
                }
            }
        }

        foreach ($saved as $invoice) {
            $invoice->delete();
        }
        if ($per) {
            foreach ($perList as $perItem) {
                $perItem->delete();
            }
        }

        foreach ($cuuList as $cu) {
            $cu->delete();
        }
        if ($delete) {
            $delete->delete();
            $cuu->delete();
            if ($per) {
                $per->delete();
            }
        }
        return redirect()->route('salesBill.index')->with('success', 'Successfully deleted');
    }

    public function print($id)
    {
        $company = Compaines::find(1);
        $branch = Branches::find(1);
        $invoice = Invoices::find($id);
        $list = SavedInvoices::where('invoiceId', $id)->get();
        $customer = Customers::find($invoice->customerId);
        return view('SalesBill.print')
            ->with('company', $company)
            ->with('invoice', $invoice)
            ->with('list', $list)
            ->with('customer', $customer)
            ->with('branch', $branch);
    }

    public function Reports()
    {
        return view('SalesBill.reports.index');
    }


    public function BillingProfits()
    {
        return view('SalesBill.reports.billing');
    }

    public function FilterBilling(Request $request)
    {

        $orders = Invoices::where('status', '!=', '3')->whereBetween('created_at', [$request->from, $request->to])->get();
        $orders->each(function ($item) {
            $item->customer = Customers::find($item->customerId)->name;
            $item->payment = $item->status == 1  ? "كاش" : "اجل";
            $item->branch_name = Branches::find($item->branchId)->namear;
            $item->details = SavedInvoices::where('invoiceId', $item->id)->get();
        });


        $orders->each(function ($item) {
            if ($item->details) {
                $item->price = 0;
                $item->total = 0;
                $item->discount = 0;
                $item->discountValue = 0;
                $item->av_price = 0;
                foreach ($item->details as $detail) {
                    $status = Itemslist::where('itemId', $detail['item_id'])
                        ->where('unitId', $detail['unit_id'])
                        ->first();

                    $newQtn = $status->packing * $detail['qtn'];
                    $detail['newQ'] = $newQtn;
                    $detail['av_price'] = $status->av_price;
                    $item->av_price += $detail['av_price'];
                    $item->price += $detail->price * $detail->qtn;
                    $item->total += $detail->total;
                    $item->discount += $detail->discountRate;
                    $item->discountValue += $detail->discountValue;
                }
            }
        });



        $orders2 = ReturnedSallesInvoice::where('status', '!=', '3')->whereBetween('created_at', [$request->from, $request->to])
            ->get();
        $orders2->each(function ($item) {
            $item->customer = Customers::find($item->customerId)->name;
            $item->payment = $item->status == 1  ? "كاش" : "اجل";
            $item->branch_name = Branches::find($item->branchId)->namear;
            $item->details = ReturnedSallesInvoiceList::where('invoiceId', $item->id)->get();
        });


        $orders2->each(function ($item) {
            if ($item->details) {
                $item->price = 0;
                $item->total = 0;
                $item->discount = 0;
                $item->discountValue = 0;
                $item->av_price = 0;
                foreach ($item->details as $detail) {
                    $status = Itemslist::where('itemId', $detail['itemId'])
                        ->where('unitId', $detail['unitId'])
                        ->first();
                    $newQtn = $status->packing * $detail['qtn'];
                    $detail['newQ'] = $newQtn;
                    $detail['av_price'] = $status->av_price;
                    $item->av_price += $detail['av_price'];
                    $item->price += $detail->price * $detail->qtn;
                    $item->total += $detail->total;
                    $item->discount += $detail->discountRate;
                    $item->discountValue += $detail->discountValue;
                }
            }
        });


        return response()->json([
            'orders' => $orders,
            'orders2' => $orders2,
        ]);
    }


    public function getCustomer($id)
    {
        $customer = Customers::find($id);
        return response()->json([
            'customer' =>$customer
        ]);
    }

    public function getProduct($id, $unit)
    {
        $item = Items::find($id);
        $list = Itemslist::where('itemId',$id)->where('unitId', $unit)->get();

        $list->each(function ($item) {
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->item_name = Items::find($item->itemId)->namear;
            $item->cost = Itemslist::where('itemId', $item->itemId)
                ->where('unitId', $item->unitId)
                ->get()
                ->first()->av_price;
            $item->units = Itemslist::where('itemId', $item->itemId)->get();
            $item->units->each(function ($row) {
                $row->unit_name = Unit::find($row->unitId)->namear;
            });

            $item->balance = QtnItems::where('item_id', $item->itemId)
                ->get()
                ->first();
            $item->small = Itemslist::where('itemId', $item->itemId)
                ->where('unitId', $item->unitId)
                ->where('small_unit', '=', 1)
                ->get()
                ->first();

            if (!$item->balance) {
                $item->balance = 0;
            }
            if ($item->balance) {
                $item->packing = Itemslist::where('itemId', $item->balance->item_id)
                    ->get()
                    ->first()->packing;
                $item->small_unit = Unit::find($item->balance->unit_id)->namear;
            }
        });
        // return $list

        return response()->json([
            'item' => $item,
            'list' => $list[0],
        ]);
    }



}
