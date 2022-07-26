<?php

namespace App\Http\Controllers;

use App\Branches;
use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\FiscalYears;
use App\Invoices;
use App\Items;
use App\Itemslist;
use App\QtnItems;

use App\StoreModel;
use App\NumOrders;
use App\PrinterSetting;
use App\SavedInvoices;
use App\Shift;
use App\TablesModal;
use App\Traits\PrinterTrait;
use App\Unit;
use App\PermissionCashing;
use App\PermissionCashingList;
use I18N_Arabic;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use App\Traits\GetAccounts;

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

use Carbon\Carbon;



require_once __DIR__ . '/ar/I18N/Arabic.php';

class POSController extends Controller
{
    use PrinterTrait;
    use GetAccounts;

    public function __construct()
    {
        // $this->middleware('active_permision');
        // $this->middleware('auth');
    }

    public function index()
    {
        $company = Compaines::all()->first();
        date_default_timezone_set('Asia/Riyadh');
        if ($company->restaurant != 1) {
            return redirect()->route('casher.index');
        }
        $lang = LaravelLocalization::getCurrentLocale();
        $customers = Customers::all();
        $items = Items::all();
        $CatrgoryItems = CategoryItems::select('name' . $lang . ' as name', 'id', 'img')->get();
        $units = Unit::all();
        $tables = TablesModal::all();
        $itemList = Itemslist::all();
        $shift = Shift::orderBy('id', 'desc')->first();
        $current_date_time = Carbon::now()->toDateTimeString();
        $stores = StoreModel::all();
        // return $shift;
        $itemList->each(function ($item) {
            $item->item_name = Items::find($item['itemId'])->namear;
            $item->unit_name = Unit::find($item['unitId'])->namear;
        });
        if ($shift) {
            if ($shift->closeing != 1) {
                if ($shift->opening != 1) {
                    $shift->opening = 1;
                    $shift->save();
                }
            } else {
            // return "11";
            $status = Shift::create();
            $status->opening = 1;
            $status->openDate = $current_date_time;
            $status->save();
            return view('POS.index')
                ->with('stores', $stores)
                ->with('customers', $customers)
                ->with('itemList', $itemList)
                ->with('items', $items)
                ->with('CatrgoryItems', $CatrgoryItems)
                ->with('units', $units)
                ->with('shiftOpening', $status)
                ->with('tables', $tables)
                ->with('company', $company);
            }
        } else {

            $status = Shift::create();
            $status->opening = 1;
            $status->openDate = $current_date_time;
            $status->save();
        }

        return view('POS.index')
            ->with('stores', $stores)
            ->with('customers', $customers)
            ->with('itemList', $itemList)
            ->with('items', $items)
            ->with('CatrgoryItems', $CatrgoryItems)
            ->with('units', $units)
            ->with('shiftOpening', $shift)
            ->with('tables', $tables)
            ->with('company', $company);
    }

    public function ItemDirect($id, $unitId)
    {
        $item = Items::find($id);
        $list = Itemslist::where('itemId', $item->id)
            ->where('unitId', $unitId)
            ->get();
        $item->unit_name = Unit::find($unitId)->namear;
        $item->unitId = $unitId;
        return response()->json([
            'item' => $item,
            'list' => $list,
        ]);
    }

    public function ItemByBarCode($barcode)
    {
        $list = Itemslist::where('barcode', $barcode)->first();
        if (!$list) {
            $list = [];
            $item = [];
        } else {
            $item = Items::find($list->itemId);
        }
        $units = Unit::all();
        return response()->json([
            'item' => $item,
            'list' => $list,
            'units' => $units,
        ]);
    }

    public function printers()
    {
        return view('POS.printer');
    }


    // done version
    public function getItem($id)
    {
        $item = Items::find($id);
        $list = Itemslist::where('itemId', $id)->get();
        $list->each(function ($item) {
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->unit_namear = Unit::find($item->unitId)->namear;
            $item->unit_nameen = Unit::find($item->unitId)->nameen;
        });
        return response()->json([
            'item' => $item,
            'list' => $list
        ]);
    }

    // done version
    public function getItemById($id)
    {
        $items = Items::where('group', $id)->get();
        $list = Itemslist::all();
        return response()->json([
            'items' => $items,
            'list' => $list,
        ]);
    }

    public function SavePayNow(Request $request)
    {
        // 1 cash
        // 2 agl
        // 3 hold

        // return $request->totalSales;
        $acc = Customers::find($request->customerId);
        $user = auth()->user();
        $comapny = Compaines::all()->first();
        $branch = Branches::find($user->barnchId);
        $shift = Shift::orderBy('id', 'desc')->first();
        // return $request;
        $company = Compaines::all()->first();
        // return $request;


        date_default_timezone_set('Asia/Riyadh');
        if ($shift->closeing != 1) {
            $list = $request->list;
            $netTotalList = 0;
            $totals = 0;
            $average_total = 0;
            $taxs = 0;

            if (count($list) > 0) {
                foreach ($list as $item) {
                    if (!isset($item['itemId'])) {
                        return response()->json([
                            "status" => 201,
                            "msg" => "من فضلك تاكد من البيانات"
                        ]);
                    }
                    if (!isset($item['unitId'])) {
                        return response()->json([
                            "status" => 201,
                            "msg" => "من فضلك تاكد من البيانات"
                        ]);
                    }
                    if (!isset($item['storeId'])) {
                        return response()->json([
                            "status" => 201,
                            "msg" => "من فضلك تاكد من البيانات"
                        ]);
                    }
                    $itemCheck = Itemslist::where('itemId', $item['itemId'])
                        ->where('unitId', $item['unitId'])
                        ->first();
                    if (!$itemCheck) {
                        return response()->json([
                            "status" => 201,
                            "msg" => "لا توجد هذة الوحدة للصنف"
                        ]);
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
                return response()->json([
                    "status" => 201,
                    "msg" => "من فضلك تاكد من البيانات"
                ]);
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
                                return response()->json([
                                    "status" => 201,
                                    "msg" => "لا يوجد رصيد للصنف"
                                ]);
                            }
                        } else {
                            return response()->json([
                                "status" => 201,
                                "msg" => "لا يوجد رصيد للصنف"
                            ]);
                        }
                    }
                }
            }
            $fiscal_year = FiscalYears::all()->first();


            $id = 1;
            $last_invoice = Invoices::all()->last();

            if ($request->voiceId != "0" && $request->voiceId != "false") {
                $invoiceHold = Invoices::find($request->voiceId);
                $invoiceHold->delete();
                $invoiceHoldList = SavedInvoices::where('invoiceId', $request->voiceId)->get();
                foreach ($invoiceHoldList as $voic) {
                    $voic->delete();
                }
            }

            $visa = 0;
            $credit = 0;
            $masterCard = 0;
            $cash = 0;
            if ($request->masterCard) $masterCard = $request->masterCard;
            if ($request->visa) $visa = $request->visa;
            if ($request->cash) $cash = $request->cash;
            if ($request->credit) $credit = $request->credit;

            if ($last_invoice) {
                $id = $last_invoice->id + 1;
            }
            if ($request->voiceId != "0" && $request->voiceId != "false") {
                $id = $request->voiceId;
            }

            $statusType = null;
            $tab = null;
            if ($request->typyInvoice) {
                $statusType = $request->typyInvoice;
            }
            if ($request->tab) {
                $tab = $request->tab;
            }


            $invoice = Invoices::create([
                'id' => $id,
                'status' => $request->status,
                'fiscal_year' => $fiscal_year->code,
                'branchId' => $branch->id,
                'shiftNum' => $shift->id,
                'netTotal' => $request->netTotal,
                'customerId' => $request->customerId,
                'visa' => $visa,
                'storeId'=>$request->storeId,
                'credit' => $credit,
                'masterCard' => $masterCard,
                'cash' => $cash,
                'status_type' => $statusType,
                'tab' => $tab,
            ]);
            if ($request->priceDeleiver && $request->priceDeleiver != 0) {
                $invoice->deleiver = $request->priceDeleiver;
                $invoice->save();
            }
            if(isset($request->tobacco_tax) && $request->tobacco_tax != 0){
                $invoice->tobacco_tax = $request->tobacco_tax;
                $invoice->save();
            }
            $numOrder = NumOrders::first();
            $numOrder->num = $numOrder->num + 1;
            $numOrder->save();
            if ($request->taxSourceValue) {
                $invoice->netTotal = $netTotalList - $request->taxSourceValue;
                $invoice->save();
            }
            if ($request->taxSource) {
                $invoice->taxSource = $request->taxSource;
                $invoice->save();
            }


            $id_permision = 1;
            $last_permision = PermissionCashing::all()->last();
            if ($last_permision) {
                $id_permision = $last_permision->id + 1;
            }

            if ($request->status != 3) {
                $permission = PermissionCashing::create([
                    'id' => $id_permision,
                    'fiscal_year' => $fiscal_year->code,
                    'source_num' => $invoice->id,
                    "fiscal_year" => $fiscal_year->code,
                    'source' => 'مبيعات',
                    'customerId' => $request->customerId,
                    'netTotal' => $netTotalList,
                    'payment' => $request->status,
                    'branchId' => $branch->id,
                    'storeId' => $request->storeId,
                ]);
            }

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
                    $itemDetails = Items::find($item['itemId']);

                    if($itemDetails->priceWithTax ==1){
                        $nettotal = $total;
                    }else {
                        $nettotal = $total + $value;
                        $totalBefore = $total + $value;
                    }

                    if($item['priceWithTax'] == 1) {
                        $totalBefore = $totalBefore + $value;
                        $nettotal = $nettotal + $value;
                    }
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
                        'storeId' => $request->storeId
                    ]);

                    $itemCheck2 = Itemslist::where('itemId', $item['itemId'])
                        ->where('unitId', $item['unitId'])
                        ->first();
                    $MainItem = Items::find($itemCheck2->itemId);

                    if ($MainItem->item_type != 3) {
                        // اذن صرف
                        if ($request->status != 3) {
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
                                'storeId' => $request->storeId,
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
            }

            if ($request->status != 3) {
                $perList = PermissionCashingList::where("source_num", $permission->id)->get();
                if (count($perList) <= 0) {
                    $permission->delete();
                }
                $this->createCuff($request, $acc, $netTotalList, $invoice, $taxs, $average_total, $totals, $branch, $request->netTotal, $request->tobacco_tax, $request->taxs, $request->totalSales);
            }
            $list = SavedInvoices::where('invoiceId', $invoice->id)->get();

            // if(isset($request->isPrint) && $request->isPrint == "true") {
            //     $this->print($request, $invoice->id, $invoice, $totals, $taxs,$request->netTotal, $request->tobacco_tax, $request->taxs, $request->totalSales);
            // }


            return response()->json([
                'msg' => 'invoice saved',
                'status' => 200,
                'invoiceId' => $invoice,
                "list" => $list,
                "company" => $comapny,
                "branch" => $branch,
                'customer' => $acc
            ]);
        } else {
            return response()->json([
                'msg' => 'لا يوجد شيفت مفتوح لحفظ الفاتورة',
                'status' => 201,
            ]);
        }
    }
    public function getQtn($item = 1, $unit = 1, $store)
    {
        $qtn = QtnItems::where('item_id', $item)
            ->where('store_id', $store)
            ->first();

        return $qtn;
    }
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
    public function createCuff($data, $account, $netTotalList = 0, $invoice, $taxs, $average_total, $totals, $branch, $netTotal, $tobacco_taxRequest,$taxsRequest,$totalSales)
    {
        $fiscal_year = FiscalYears::all()->first();
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
        $tobacco_tax = 0;

        $priceDeleiverD = 0;
        if ($data->priceDeleiver) {
            $priceDeleiverD = $data->priceDeleiver;
        }
        $company = Compaines::all()->first();
        if($company->tobacco_tax == 1){
            $tobacco_tax = $totals;
            $taxs = $taxs * 2;
        }

        $idIn = DailyRestrictions::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'document' => '',
            'description' => '',
            'branshId' => $branch->id,
            'source' => $invoice->id,
            'source_name' => 'مبيعات',
            'creditor' => $netTotal,
            'debtor' => $netTotal,
        ]);

        // هيتضاف علية التوصيل
        if ($data->status == 1 || $data->status == 10 || $data->status == 4) {

            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotal,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totalSales,
                'description' => '',
            ]);
            if ($data->costCenter) {
                $SalesDail->cost_center = $data->costCenter;
                $SalesDail->save();
            }


            // new
            if ($data->priceDeleiver && $data->priceDeleiver != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 55,
                    'account_name' => 'خدمة توصيل',
                    'debtor' => 0,
                    'creditor' => $priceDeleiverD,
                    'description' => '',
                ]);
            } // new

            if ($data->taxSourceValue != 0 && $data->taxSourceValue != "") {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 40,
                    'account_name' => 'ضريبة خصم المنبع',
                    'debtor' => $val,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            if ($taxsRequest != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 23,
                    'account_name' => 'ضريبة القيمة المضافة',
                    'debtor' => 0,
                    'creditor' => $taxsRequest,
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
            if ($company->tobacco_tax == 1){
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 56,
                    'account_name' => 'ضريبة تبغ',
                    'debtor' => 0,
                    'creditor' => $tobacco_taxRequest,
                    'description' => '',
                ]);
                // DailyRestrictionsList::create([
                //     'invoice_id' => $idIn->id,
                //     'account_id' => $account->account_id,
                //     'account_name' => $account->name,
                //     'debtor' => $tobacco_tax + $netTotalList - $val + $priceDeleiverD,
                //     'creditor' => 0 ,
                //     'description' => '',
                // ]);
            }
            //
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => $netTotal,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $netTotal,
                'description' => '',
            ]);
        }


        if ($data->status == 2) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotal,
                'creditor' => 0,
                'description' => '',
            ]);
            $SalesDail = DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 25,
                'account_name' => 'المبيعات',
                'debtor' => 0,
                'creditor' => $totalSales,
                'description' => '',
            ]);
            if ($data->costCenter) {
                $SalesDail->cost_center = $data->costCenter;
                $SalesDail->save();
            }


            // new
            if ($data->priceDeleiver && $data->priceDeleiver != 0) {
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 55,
                    'account_name' => 'خدمة توصيل',
                    'debtor' => 0,
                    'creditor' => $priceDeleiverD,
                    'description' => '',
                ]);
            } // new


            if ($data->taxSourceValue != 0 && $data->taxSourceValue != "") {
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
                    'creditor' => $taxsRequest,
                    'description' => '',
                ]);
            }


            if ($company->tobacco_tax == 1){
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 56,
                    'account_name' => 'ضريبة تبغ',
                    'debtor' => 0,
                    'creditor' => $tobacco_taxRequest,
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

    public function HoldInvoice($request, $printerName, $customers, $company, $user, $branch, $shift)
    {
        $textar = '';
        $texten = '';

        if ($request->typyInvoice == '3') {
            $textar = 'سفري';
            $texten = 'Takeaway';
        }
        if ($request->typyInvoice == '4') {
            $textar = 'محلي';
            $texten = 'Mahli';
        }
        if ($request->typyInvoice == '5') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Tawlat';
        }
        if ($request->typyInvoice == '6') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Takeaway';
        }

        $this->validate($request, [
            'netTotal' => 'required',
            'customerId' => 'required',
        ]);
        $numOrder = NumOrders::first();
        $numOrder->num = $numOrder->num + 1;
        $numOrder->save();

        $invoice = Invoices::create([
            'branchId' => $branch->id,
            'status' => $request->status,
            'netTotal' => $request->netTotal,
            'shiftNum' => $shift->id,
            'customerId' => $request->customerId,
            'cash' => 0,
            'visa' => 0,
            'masterCard' => 0,
            'credit' => 0,
        ]);

        if ($request->list) {
            foreach ($request->list as $item) {
                SavedInvoices::create([
                    'status' => $request->status,
                    'invoiceId' => $invoice->id,
                    'unit_id' => $item['unitId'],
                    'item_id' => $item['itemId'],
                    'item_name' => $item['name'],
                    'qtn' => $item['qtn'],
                    'price_after_tax' => $item['priceafterTax'],
                    'tax_value' => $item['TaxVal'],
                    'customer_id' => $request->customerId,
                ]);
            }
        }

        return response()->json([
            'msg' => 'invoice saved',
            'status' => 200,
            'data' => $request->list,
            'customers' => $customers,
            'company' => $company,
            'branch' => $branch,
            'invoiceId' => $invoice,
        ]);
    }

    public function PaymentMethods($request, $printerName, $customers, $company, $user, $branch, $shift)
    {
        $total = $request->cash + $request->masterCard + $request->credit + $request->visa;
        // return $request;
        if ($total < $request->netTotal) {
            return response()->json([
                'msg' => 'صافي الفاتورة لا يساوي اجمالي الدفعات',
                'status' => 201,
            ]);
        }
        if ($total > $request->netTotal) {
            return response()->json([
                'msg' => 'صافي الفاتورة اقل من اجمالي الدفعات',
                'status' => 201,
            ]);
        }

        $textar = '';
        $texten = '';
        $textPay = '';
        if ($request->visa != 0) {
            $textPay .= 'Visa ,';
        }
        if ($request->masterCard != 0) {
            $textPay .= ' masterCard ,';
        }
        if ($request->credit != 0) {
            $textPay .= ' Credit ,';
        }
        if ($request->cash != 0) {
            $textPay .= ' Cash ';
        }

        if ($request->typyInvoice == '3') {
            $textar = 'سفري';
            $texten = 'Takeaway';
        }
        if ($request->typyInvoice == '4') {
            $textar = 'محلي';
            $texten = 'Mahli';
        }
        if ($request->typyInvoice == '5') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Tawlat';
        }
        if ($request->typyInvoice == '6') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Takeaway';
        }

        $numOrder = NumOrders::first();
        $numOrder->num = $numOrder->num + 1;
        $numOrder->save();

        $invoice = Invoices::create([
            'branchId' => $branch->id,
            'status' => $request->status,
            'netTotal' => $request->netTotal,
            'shiftNum' => $shift->id,
            'customerId' => $request->customerId,
            'cash' => 0,
            'visa' => 0,
            'masterCard' => 0,
            'credit' => 0,
        ]);

        if ($request->cash) {
            $invoice->cash = $request->cash;
            $invoice->save();
        }
        if ($request->visa) {
            $invoice->visa = $request->visa;
            $invoice->save();
        }
        if ($request->masterCard) {
            $invoice->masterCard = $request->masterCard;
            $invoice->save();
        }
        if ($request->credit) {
            $invoice->credit = $request->credit;
            $invoice->save();
        }

        // Genertae Qr

        $connector = new WindowsPrintConnector($printerName->printcasher);
        $printer = new Printer($connector);
        mb_internal_encoding('UTF-8');
        $Arabic = new I18N_Arabic('Glyphs');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 25;
        // date
        // date_default_timezone_set('Africa/Cairo');
        $date = date('Y-m-d h:i:s a', time());
        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        $img = EscposImage::load(public_path() . '/comp' . '/' . $company->logo);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->bitImage($img);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->feed();

        $printer->setTextSize(3, 4);
        $textLtr = $Arabic->utf8Glyphs($company->companyNameAr);
        $textLB = $Arabic->utf8Glyphs('الفرع : ' . $branch->namear);
        $printer->text($textLB . '   ' . $textLtr);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('الرقم الضريبي   ');
        $ss = $printer->text($company->taxNum . '  ' . $textLtr . "\n");
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('تاريخ الفاتورة   ');
        $ss = $printer->text($date . '  ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('رقم الفاتورة    ' . $invoice->id);
        $printer->text($textLtr);
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
        $printer->text($texten . ' ' . $textLtr);
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $textLtr = $Arabic->utf8Glyphs('رقم الاوردر   ');
        $ss = $printer->text($numOrder->num . '  ' . $textLtr . "\n");
        $printer->feed();
        $printer->text('Payment Methods : ' . $textPay . "\n\n");
        $printer->feed();

        $head = $this->addItemHead($this->getArabic('الصنف', $Arabic), $this->getArabic('سعر', $Arabic), $this->getArabic('كمية', $Arabic), $this->getArabic('اجمالى', $Arabic));
        $printer->text($head);
        $printer->text($this->line());

        if ($request->list) {
            foreach ($request->list as $item) {
                $unitnamear = Unit::find($item['unitId'])->namear;
                $unitnameen = Unit::find($item['unitId'])->nameen;
                SavedInvoices::create([
                    'status' => $request->status,
                    'invoiceId' => $invoice->id,
                    'unit_id' => $item['unitId'],
                    'item_id' => $item['itemId'],
                    'item_name' => $item['name'],
                    'qtn' => $item['qtn'],
                    'price_after_tax' => $item['priceafterTax'],
                    'tax_value' => $item['TaxVal'],
                    'customer_id' => $request->customerId,
                ]);
                // مش فاتورة العميل
                $itemCols = 16 + $this->actualLength($item['nameen']);
                $priceCols = 8 + $this->actualLength($item['price']);
                $quantityCols = 8 + $this->actualLength($item['qtn']);
                $totalCols = 4 + $this->actualLength($item['total']);
                $text = str_pad($item['nameen'] . ' - ' . $unitnameen, $itemCols);
                $text .= str_pad($item['price'], $priceCols, ' ', STR_PAD_LEFT);
                $text .= str_pad($item['qtn'], $quantityCols, ' ', STR_PAD_LEFT);
                $text .= str_pad($item['total'], $totalCols, ' ', STR_PAD_LEFT);

                $printer->text($text . "\n");
                $printer->text($this->line());
                $text = $this->addItemHead($this->getArabic($item['namear'] . ' - ' . $unitnamear, $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic));
                $printer->text($text . "\n");
                $printer->text($this->line());
            }
        }

        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $textLtr = $Arabic->utf8Glyphs('الاجمالي قبل الضريبة');
        $ss = $printer->text($request->totalAfter . '             ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('ضريبة القيمة المضافة   ');
        $ss = $printer->text($request->taxVals . '        ' . ' 15% ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('المجموع شامل الضريبة ');
        $ss = $printer->text($request->netTotal . '              ' . $textLtr . "\n");
        $printer->feed();

        $displayQRCodeAsBase64 = GenerateQrCode::fromArray([new Seller($company->companyNameAr), new TaxNumber($company->taxNum), new InvoiceDate($invoice->created_at), new InvoiceTotalAmount($request->netTotal), new InvoiceTaxAmount($request->taxVals)])->render();

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        // Qr Genertator VT
        $imageBlob = base64_decode(explode(',', $displayQRCodeAsBase64)[1]);
        $imagick = new \Imagick();
        $imagick->setResourceLimit(6, 1);
        $imagick->readImageBlob($imageBlob, 'input.png');
        $im = new ImagickEscposImage();
        $im->readImageFromImagick($imagick);
        $printer->bitImage($im);

        $textLtr = $Arabic->utf8Glyphs('عنوان الفرع : ' . $branch->address);
        $printer->text($textLtr);
        $printer->feed();

        $printer->cut();
        $printer->pulse();
        $printer->close();

        // printkitchen
        if ($printerName->printkitchen) {
            $connector = new WindowsPrintConnector($printerName->printkitchen);
            $printer = new Printer($connector);
            $buffer = new ImagePrintBuffer();
            $buffer->setFontSize($fontSize);
            $buffer->setFont($fontPath);
            $printer->setPrintBuffer($buffer);

            $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
            $printer->text($textLtr);
            $printer->text('Typy Order   : ' . $texten);
            $printer->feed();

            $printer->text('Date   : ' . $date);
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->text('Num Order : ' . $numOrder->num . "\n\n");
            $printer->feed();
            $printer->feed();

            $head = $this->addItemHead($this->getArabic('الصنف', $Arabic), $this->getArabic(' ', $Arabic), $this->getArabic('كمية', $Arabic), $this->getArabic(' ', $Arabic));
            $printer->text($head);
            $printer->text($this->line());

            if ($request->list) {
                foreach ($request->list as $item) {
                    $unitnamear = Unit::find($item['unitId'])->namear;
                    $unitnameen = Unit::find($item['unitId'])->nameen;
                    $invoice->img = $item['img'];
                    $invoice->unitId = $item['unitId'];
                    $invoice->price = $item['price'];
                    $invoice->priceWithTax = $item['priceWithTax'];
                    $invoice->itemId = $item['itemId'];
                    $invoice->qtn = $item['qtn'];
                    $invoice->groupItem = $item['group'];
                    $invoice->description = $item['description'];
                    $invoice->namear = $item['namear']; //
                    $invoice->nameen = $item['nameen']; //
                    $invoice->total = $item['total'];
                    $invoice->quantityM = $item['quantityM'];
                    $invoice->taxRate = $item['taxRate'];
                    $invoice->status = $request['status'];
                    // مش فاتورة العميل
                    $itemCols = 19 + $this->actualLength($item['nameen']);
                    $priceCols = 1 + $this->actualLength(' ');
                    $quantityCols = 12 + $this->actualLength($item['qtn']);
                    $totalCols = 8 + $this->actualLength(' ');
                    $text = str_pad($item['nameen'] . ' - ' . $unitnameen, $itemCols);
                    $text .= str_pad(' ', $priceCols, ' ', STR_PAD_LEFT);
                    $text .= str_pad($item['qtn'], $quantityCols, ' ', STR_PAD_LEFT);
                    $text .= str_pad(' ', $totalCols, ' ', STR_PAD_LEFT);

                    $printer->text($text . "\n");
                    $printer->text($this->line());
                    $text = $this->addItemHead($this->getArabic($item['namear'] . ' - ' . $unitnamear, $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic));
                    $printer->text($text . "\n");
                    $printer->text($this->line());
                }
            }
            $printer->feed();
            $printer->cut();
            $printer->pulse();
            $printer->close();
        }

        return response()->json([
            'msg' => 'invoice saved',
            'status' => 200,
            'data' => $request->list,
            'customers' => $customers,
            'company' => $company,
            'branch' => $branch,
            'invoiceId' => $invoice,
        ]);
    }

    public function openShift()
    {
        $shift = Shift::orderBy('id', 'desc')->first();
        date_default_timezone_set('Asia/Riyadh');
        $current_date_time = Carbon::now()->toDateTimeString();
        if ($shift) {
            if ($shift->closeing != 1) {
                if ($shift->opening != 1) {
                    $shift->opening = 1;
                    $shift->save();
                }
                return response()->json([
                    'msg' => 'Successfully Shift Opening',
                    'status' => 200,
                    'shift' => $shift,
                ]);
            } else {
                $status = Shift::create();
                $status->opening = 1;
                $status->openDate = $current_date_time;
                $status->save();
                return response()->json([
                    'msg' => 'Successfully Shift Opening',
                    'status' => 200,
                    'shift' => $status,
                ]);
            }
        } else {
            $status = Shift::create();
            $status->opening = 1;
            $status->openDate = $current_date_time;
            $status->save();
            return response()->json([
                'msg' => 'Successfully Shift Opening',
                'status' => 200,
                'shift' => $status,
            ]);
        }
    }

    public function closeShift()
    {
        $shift = Shift::orderBy('id', 'desc')->first();
        date_default_timezone_set('Asia/Riyadh');
        $current_date_time = date('Y-m-d H:i:s', time());
        $orders = Invoices::where('status', '!=', '3')->where('status', '!=', '4')->whereBetween('created_at', [$shift->openDate, $current_date_time])->get();
        $Invoices = SavedInvoices::get();
        $customers = Customers::all();
        $units = Unit::all();

        $company = Compaines::find(1);
        $branch = Branches::where('companyId', $company->id)->first();
        $InvoicesDetails = [];
        $InvoicesHolder = [];

        foreach ($orders as $order) {
            foreach ($Invoices as $invoicesave) {
                if ($invoicesave->invoiceId == $order->id) {
                    $InvoicesDetails[] = $invoicesave;
                }
            }
        }

        collect($InvoicesDetails)->each(function ($item) {
            $unit = Unit::find($item->unit_id);
            if ($unit) {
                $item->unit_name = Unit::find($item->unit_id)->namear;
            } else {
                $item->unit_name = "null";
            }
        });
        return response()->json([
            'msg' => 'Successfully Shift Close',
            'status' => 200,
            'shift' => $shift,
            'Orders' => $orders,
            'InvoicesDetails' => $InvoicesDetails,
            'InvoicesHolder' => $InvoicesHolder,
            'customers' => $customers,
            'company' => $company,
            'branch' => $branch,
            'units' => $units,
        ]);
    }

    public function endShift(Request $request)
    {
        $namePrinter = PrinterSetting::get()->first();
        $shift = Shift::orderBy('id', 'desc')->first();

        date_default_timezone_set('Asia/Riyadh');
        $current_date_time = date('Y-m-d H:i:s', time());
        if ($shift->opening != 0) {
            $shift->opening = 0;
            $shift->closeing = 1;
            $shift->closeDate = $current_date_time;
            $shift->save();
        }
        $numOrder = NumOrders::first();
        $numOrder->num = 0;
        $numOrder->save();
        $user = auth()->user();
        $branch = Branches::find($user->barnchId);

        $textar = '';
        $texten = '';

        if ($request->typyInvoice == '3') {
            $textar = 'سفري';
            $texten = 'Takeaway';
        }
        if ($request->typyInvoice == '4') {
            $textar = 'محلي';
            $texten = 'Mahli';
        }
        if ($request->typyInvoice == '6') {
            $textar = 'توصيل';
            $texten = 'Delivery';
        }
        if ($request->typyInvoice == '7') {
            $textar = 'حجز';
            $texten = 'Reservation';
        }
        $newList = [];
        $average_total = 0;
        // return $request->Optimzation;
        if (count($request->Optimzation) > 0) {
            foreach ($request->Optimzation as $item) {
                $status = Itemslist::where('itemId', $item['item_id'])
                    ->where('unitId', $item['unit_id'])
                    ->first();

                if (!$status) {
                    return response()->json([
                        'msg' => 'لا يوجد هذا الصنف',
                        'status' => 201,
                    ]);
                }
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $newList[] = $item;
            }
        }
        $customer = Customers::find($request->customerId);

        // first Printer ****
        $connector = new WindowsPrintConnector($namePrinter->printcasher);
        $printer = new Printer($connector);
        $printer->initialize();

        $total = 0;

        $company = Compaines::find(1);
        // $connector = new WindowsPrintConnector($namePrinter->printcasher);
        // $printer = new Printer($connector);
        mb_internal_encoding('UTF-8');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 25;
        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        $img = EscposImage::load(public_path() . '/comp' . '/' . $company->logo);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->bitImage($img);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);

        $Arabic = new I18N_Arabic('Glyphs');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 25;
        // date
        date_default_timezone_set('Africa/Cairo');
        $date = date('d/m/y h:i:s a', time());

        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        $textLtr = $Arabic->utf8Glyphs('الفرع   : ' . $branch->namear);
        $printer->text($textLtr);
        $textLtr = $Arabic->utf8Glyphs('البائع   ' . $user->name . ':');
        $printer->text($textLtr);
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text('Start Shify : ' . $shift->openDate . "\n");
        $printer->text('End Shify : ' . $shift->closeDate);


        $printer->setJustification(Printer::JUSTIFY_CENTER);


        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('تقرير يومية');
        $printer->text($textLtr);
        $printer->feed();
        $printer->feed();


        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $head = $this->addItemHeadCustomer($this->getArabic('اجمالى', $Arabic), $this->getArabic('كمية', $Arabic), $this->getArabic('سعر', $Arabic), $this->getArabic('الصنف', $Arabic));
        $printer->text($head);
        $printer->text($this->line());

        // *****************(*)
        // اذن صرف
        // return $request->list;
        if ($request->Optimzation) {
            foreach ($request->Optimzation as $item) {
                $mainItem = Items::find($item['item_id']);
                $unit = Unit::find($item['unit_id']);
                $total += $item['qtn'] * $item['price'];
                $text = $this->addItemHeadCustomer($item['qtn'] * $item['price'], $item['qtn'],  $this->getArabic($item['price'], $Arabic),  $this->getArabic($mainItem['namear'] . ' ' . $unit->namear, $Arabic));
                $printer->text($text . "\n");
                $printer->text($this->line());
            }
        }

        // *****************(*)

        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $text = $Arabic->utf8Glyphs('اجمالي المبيعات ' . $total . ":");
        $printer->text($text);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs($branch->address);
        $printer->text($textLtr);
        $printer->feed();

        $printer->cut();
        $printer->pulse();
        $printer->close();

        return response()->json([
            'msg' => 'Successfully Shift Close',
            'status' => 200,
            'path' => 'http://localhost/erp/public/',
        ]);
    }

    public function closeShiftPrinter()
    {
        return view('POS.closeShiftPrinter');
    }

    public function GetHoldInvoice()
    {
        $shift = Shift::orderBy('id', 'desc')->first();
        date_default_timezone_set('Asia/Riyadh');
        $current_date_time = date('Y-m-d H:i:s', time());
        $orders1 = Invoices::where('status', '=', '3')
            ->whereBetween('created_at', [$shift->openDate, $current_date_time])
            ->get();
        $orders2 = Invoices::where('status', '=', '4')
            ->whereBetween('created_at', [$shift->openDate, $current_date_time])
            ->get();

        $orders = $orders1->merge($orders2);

        return response()->json([
            'msg' => 'Successfully Shift Close',
            'status' => 200,
            'shift' => $shift,
            'Orders' => $orders,
        ]);
    }

    public function getInvoice($id)
    {
        $order = Invoices::where('id', '=', $id)->first();
        $list = SavedInvoices::where('invoiceId', '=', $order->id)->get();
        $list->each(function ($item) {
            $item->unit_name = Unit::find($item->unit_id)->namear;
        });

        return response()->json([
            'msg' => 'done activate',
            'status' => 200,
            'order' => $order,
            'id' => $id,
            'list' => $list,
        ]);
    }

    public function ActiveHoldInvoice($id)
    {
        $order = Invoices::where('id', '=', $id)->first();
        $details = SavedInvoices::where('invoiceId', '=', $order->id)->get();
        $units = Unit::all();

        return response()->json([
            'msg' => 'done activate',
            'status' => 200,
            'order' => $order,
            'id' => $id,
            'units' => $units,
            'details' => $details,
        ]);
        // $order->status = 3;
        // $order->save();
        // return response()->json([
        //     'msg' => "done activate",
        //     'status' => 200,
        //     'order' => $order,
        //     'id' => $id,
        // ]);
    }


    public function print($request, $invoiceId, $invoice, $totals, $taxsValue, $netTotal, $tobacco_tax, $taxs, $totalSales)
    {
        $printerName = PrinterSetting::first();
        $company = Compaines::all()->first();
        $user = auth()->user();
        $branch = Branches::find($user->barnchId);
        $numOrder = NumOrders::first();


        $textar = '';
        $texten = '';

        if ($request->typyInvoice == '5') {
            $textar = 'سفري';
            $texten = 'Takeaway';
        }
        if ($request->typyInvoice == '6') {
            $textar = 'محلي';
            $texten = 'Mahli';
        }
        if ($request->typyInvoice == '4') {
            $textar = 'توصيل';
            $texten = 'Delivery';
        }
        if ($request->typyInvoice == '8') {
            $textar = 'حجز';
            $texten = 'Reservation';
        }
        $newList = [];
        $average_total = 0;
        if (count($request->list) > 0) {
            foreach ($request->list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                if (!$status) {
                    return response()->json([
                        'msg' => 'لا يوجد هذا الصنف',
                        'status' => 201,
                    ]);
                }
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $newList[] = $item;
            }
        }
        $customer = Customers::find($request->customerId);

        // first Printer ****
        $connector = new WindowsPrintConnector($printerName->printcasher);
        $printer = new Printer($connector);
        $printer->initialize();
        mb_internal_encoding('UTF-8');
        $Arabic = new I18N_Arabic('Glyphs');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 28;
        // date
        date_default_timezone_set('Asia/Riyadh');
        $date = date('Y-m-d h:i:s a', time());
        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        $img = EscposImage::load(public_path() . '/comp' . '/' . $company->logo);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->bitImage($img);
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed();
        $printer->setTextSize(3, 4);

        $textLtr = $Arabic->utf8Glyphs($company->companyNameAr);
        $textLB = $Arabic->utf8Glyphs('الفرع : ' . $branch->namear);
        $printer->text($textLtr);
        $printer->feed();
        $printer->text($textLB);
        $printer->feed();
        $text = $company->taxNum . " : " . $Arabic->utf8Glyphs(' الرقم الضريبي ') ;
        $printer->text($text);
        $printer->feed();
        $text = $customer->name . " : " . $Arabic->utf8Glyphs(' اسم العميل ') ;
        $printer->text($text);
        $printer->feed();

        $text = $customer->phone . " : " . $Arabic->utf8Glyphs(' موبايل العميل ') ;
        $printer->text($text);
        $printer->feed();

        $text = $Arabic->utf8Glyphs('عنوان العميل : ' . $customer->address);
        $printer->text($text);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('تاريخ الفاتورة   ');
        $printer->text($date . "\n");
        // $ss = $printer->text($date . '  ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('فاتورة ضريبيه مبسطه ');
        $printer->text($textLtr);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('رقم الفاتورة    ' . $invoiceId);
        $printer->text($textLtr);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
        $printer->text($texten . ' ' . $textLtr);
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $textLtr = $Arabic->utf8Glyphs('رقم الاوردر   ');
        $printer->text($numOrder->num . '  ' . $textLtr . "\n");
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $head = $this->addItemHeadCustomer($this->getArabic('اجمالى', $Arabic), $this->getArabic('سعر', $Arabic),  $this->getArabic('كمية', $Arabic), $this->getArabic('الصنف', $Arabic));
        $printer->text($head);
        $printer->text($this->line());

        // *****************(*)
        // اذن صرف
        // return $request->list;

        $taxs = 0;
        $total = 0;
        if ($request->list) {
            foreach ($request->list as $item) {
                $mainItem = Items::find($item['itemId']);
                $listItem = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                $unit = Unit::find($item['unitId']);
                // return $unit;
                if (isset($item['value'])) {
                    $taxs += $item['value'];
                }
                $total += $item['qtn'] * $item['price'];

                $description = '';
                if (isset($item['description']) && $item['description'] != "") {
                    $description = $item['description'];
                }


                $invoice->unitId = $item['unitId'];
                $invoice->price = $item['price'];
                $invoice->itemId = $item['itemId'];
                $invoice->qtn = $item['qtn'];
                $invoice->namear = $mainItem['namear']; //
                $invoice->nameen = $mainItem['nameen']; //
                $invoice->status = $request['status'];

                $priceing = number_format($item['price'], 2);
                $totalingVal = number_format($item['qtn'] * $item['price'], 2);


                $text = $this->addItemHeadCustomer($totalingVal,   $priceing, $item['qtn'], $this->getArabic($mainItem['namear'] . ' ' . $unit->namear, $Arabic));
                $printer->text($text . "\n");
                $text = $this->addItemHeadCustomer($Arabic->utf8Glyphs($description), '', '', $mainItem['nameen']);
                $printer->text($text . "\n");
                $printer->text($this->line());
            }
        }

        // *****************(*)

        $printer->feed();

        $text = $this->addItemHeadTotal($Arabic->utf8Glyphs('الصافي'), $Arabic->utf8Glyphs('ضريبه'), $Arabic->utf8Glyphs('توصيل'),  $Arabic->utf8Glyphs('خصم'),   $Arabic->utf8Glyphs('الاجمالي'));
        $printer->text($text . "\n");
        $printer->text($this->line());

        $del = 0;
        if ($request->priceDeleiver) {
            $del = $request->priceDeleiver;
        }

        $totalsVal = number_format((+$totals + +$del), 2);
        $SafeVal = number_format($taxs, 2);

        $nessw = +$totals + +$taxsValue;

        $ssaaffee = number_format($netTotal, 2);

        $text = $this->addItemHeadTotal(+$netTotal, $taxs, +$del, 0, +$totalSales);
        $printer->text($text . "\n");
        $printer->text($this->line());

        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $com= strval($company->companyNameAr);
        $com2= strval($company->taxNum);
        $com3= strval((+$total + +$del + $taxsValue));
        $com4= strval($taxsValue);

          // Genertae Qr
          $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
            new Seller($com),
            new TaxNumber($com2),
            new InvoiceDate(Carbon::now()->toDateTimeString()),
            new InvoiceTotalAmount($com3),
            new InvoiceTaxAmount($com4)
        ])->render();

        // Qr Genertator VT

        $setting = PrinterSetting::find(1);


        if($setting->print_qr == 1){
            $imageBlob = base64_decode(explode(',', $displayQRCodeAsBase64)[1]);
            $imagick = new \Imagick();
            $imagick->setResourceLimit(6, 1);
            $imagick->readImageBlob($imageBlob, 'input.png');
            $im = new ImagickEscposImage();
            $im->readImageFromImagick($imagick);
            $printer->bitImage($im);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setJustification(Printer::JUSTIFY_CENTER);

        }

        $textLtr = $Arabic->utf8Glyphs($branch->address);
        $printer->text($textLtr);
        $printer->feed();

        $printer->cut();
        $printer->pulse();
        $printer->close();

        // printkitchen

        if ($printerName->printkitchen) {
            $connector = new WindowsPrintConnector($printerName->printkitchen);
            $printer = new Printer($connector);
            $buffer = new ImagePrintBuffer();
            $buffer->setFontSize($fontSize);
            $buffer->setFont($fontPath);
            $printer->setPrintBuffer($buffer);

            $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
            $printer->text($textLtr);
            $printer->text('Typy Order   : ' . $texten);
            $printer->feed();

            $printer->text('Date   : ' . $date);
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->text('Num Order : ' . $numOrder->num . "\n\n");
            $printer->feed();
            $printer->feed();

            $head = $this->addItemHead($this->getArabic('كمية', $Arabic), '', '',  $this->getArabic('الصنف', $Arabic));
            $printer->text($head);
            $printer->text($this->line());

            if ($request->list) {
                foreach ($request->list as $item) {
                    $mainItem = Items::find($item['itemId']);
                    $listItem = Itemslist::where('itemId', $item['itemId'])->where('unitId', $item['unitId'])->first();
                    $unit = Unit::find($item['unitId']);
                    // return $unit;
                    $invoice->unitId = $item['unitId'];
                    $invoice->price = $item['price'];
                    $invoice->itemId = $item['itemId'];
                    $invoice->qtn = $item['qtn'];
                    $invoice->namear = $mainItem['namear']; //
                    $invoice->nameen = $mainItem['nameen']; //
                    $invoice->status = $request['status'];

                    $description = '';
                    if (isset($item['description']) && $item['description'] != "") {
                        $description = $item['description'];
                    }

                    $text = $this->addItemHead($item['qtn'], '', '', $this->getArabic($mainItem['namear'] . ' ' . $unit->namear, $Arabic));
                    $printer->text($text . "\n");
                    $text = $this->addItemHeadCustomer($Arabic->utf8Glyphs($description), '', '', $mainItem['nameen']);
                    // $text = $this->addItemHead($Arabic->utf8Glyphs($description), '', '', '');
                    $printer->text($text . "\n");
                    $printer->text($this->line());
                }
            }
            $printer->feed();
            $printer->cut();
            $printer->pulse();
            $printer->close();
        }
    }
}
