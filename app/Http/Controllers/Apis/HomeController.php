<?php

namespace App\Http\Controllers\Apis;

use App\Branches;
use App\CategoryItems;
use App\Compaines;
use App\Customers;
use App\FiscalYears;
use App\Http\Controllers\Controller;
use App\Invoices;
use App\Items;
use App\Itemslist;
use App\NumOrders;
use App\PermissionCashing;
use App\PermissionCashingList;
use App\QtnItems;
use App\SavedInvoices;
use App\Shift;
use App\StoreModel;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\Employees;
use App\ItemsAssembly;
use App\ItemsAssemblyList;
use App\PermissionAdd;
use App\PermissionAddList;
use App\Purchases;
use App\PurchasesList;
use App\Supplier;
use App\Unit;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {
        $products = count(Items::all());
        $stores = count(StoreModel::all());
        $users = count(User::all());
        $branchs = count(Branches::all());

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


        return response()->json([
            'products'=> $products,
            'stores'=> $stores,
            'users'=> $users,
            'branchs'=> $branchs,
            'chart'=> $data,
        ]);
    }


    public function getBranchs()
    {
        $branchs = Branches::all();
        return response()->json([
            'branchs'=> $branchs,
        ]);
    }

    public function getCustomers()
    {
        $customers = Customers::paginate(10);
        $customers->each(function($el){
            $el->deleg = Employees::find($el->delegateId);
            if($el->deleg) {
                $el->delegName = Employees::find($el->delegateId)->namear;
            }else {
                $el->delegName  ="";
            }
        });
        return response()->json([
            'customers'=> $customers,
        ]);
    }


    public function itemsBalance()
    {
        $items = Items::where('item_type','!=',3)->get();
        $branches = Branches::all();
        $stores = StoreModel::all();
        $groups = CategoryItems::all();
        $items->each(function ($item) {
            if (Unit::find($item->catId)) {
                $item->unit_name = Unit::find($item->catId)->namear;
            }
            $item->unit_id = $item->catId;
        });

        return response()->json([
            'branches'=> $branches,
            'groups'=> $groups,
            'stores'=> $stores,
            'items'=> $items,
        ]);
    }

    public function itemsBalanceFilter(Request $request)
    {
        $qtn = [];

        if($request->itemId){
           foreach ($request->itemId as $itemId) {
               $isItem = QtnItems::where('item_id', $itemId)->get();
               if($isItem){
                   foreach ($isItem as $value) {
                       $qtn[] = $value;
                   }
               }
           }
        }

       collect($qtn)->each(function($item){
           $item->item_name = Items::find($item->item_id)->namear;
           $item->unit_name = Unit::find($item->unit_id)->namear;
           $item->store_name = StoreModel::find($item->store_id)->namear;
       });
       return $qtn;
    }
    public function items()
    {
        $products = Items::all();
        $products->each(function($item){
            $item->category =  CategoryItems::find($item->group)->namear;
            $item->price =  Itemslist::where('itemId', $item->id)->get()[0]->price1;
            $item->list =  Itemslist::where('itemId', $item->id)->get();
        });
        return response()->json([
            'products'=> $products,
        ]);
    }

    // تقارير الاصناف كارت الصنف
    public function itemFilter(Request $request)
    {
        return $request;
        $list = PermissionAddList::where('itemId', $request->item_id)->get();
        $listCollection = ItemsAssemblyList::where('itemId', $request->item_id)->get();
        $listCollection2 = ItemsAssembly::where('itemId', $request->item_id)->get();
        // return $list;

        $listCollection->each(function ($item) {
            $item->source = "تجميع الاصناف";
            $item->source_num = ItemsAssembly::find($item->assembly_id)->id;
            $item->storeId = ItemsAssembly::find($item->assembly_id)->storeId;
            $item->date = ItemsAssembly::find($item->assembly_id)->startDate;
            $item->store_name = StoreModel::find(ItemsAssembly::find($item->assembly_id)->storeId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->price = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->get()->first()->av_price;
            $item->total = $item->price * $item->qtn;
            $item->nettotal = $item->price * $item->qtn;
        });
        $listCollection2->each(function ($item) {
            $item->source = "تجميع الاصناف";
            $item->source_num = $item->id;
            $item->storeId = $item->storeId;
            $item->date = $item->startDate;
            $item->store_name = StoreModel::find($item->storeId)->namear;
            $item->unit_name = Unit::find($item->unitId)->namear;
            $item->price = Itemslist::where('itemId', $item->itemId)->where('unitId', $item->unitId)->get()->first()->av_price;
            $item->total = $item->price * $item->qtn;
            $item->nettotal = $item->price * $item->qtn;
        });

        $list->each(function ($item) {
            $item->source = PermissionAdd::find($item->source_num)->source;
            $item->date = PermissionAdd::find($item->source_num)->dateInvoice;
            $item->branchId = PermissionAdd::find($item->source_num)->branchId;
            $item->branch_name = Branches::find(PermissionAdd::find($item->source_num)->branchId)->namear;
            $item->store_name = StoreModel::find(1)->namear;
            // $item->store_name = StoreModel::find($item->storeId)->namear;
            if (Unit::find($item->unitId)) {
                $item->unit_name = Unit::find($item->unitId)->namear;
            }
        });

        $list2 = PermissionCashingList::where('itemId', $request->item_id)->get();
        $list2->each(function ($item) {
            $item->source = PermissionCashing::find($item->source_num)->source;
            $item->date = PermissionCashing::find($item->source_num)->dateInvoice;
            $item->branchId = PermissionCashing::find($item->source_num)->branchId;
            $item->branch_name = Branches::find(PermissionCashing::find($item->source_num)->branchId)->namear;
            $item->store_name = StoreModel::find(1)->namear;
            // $item->store_name = StoreModel::find($item->storeId)->namear;
            if (Unit::find($item->unitId)) {
                $item->unit_name = Unit::find($item->unitId)->namear;
            }
        });


        // new

        return response()->json([
            'list' => $list,
            'list2' => $list2,
            'item' => $list2,
            'listCollection' => $listCollection,
            'listCollection2' => $listCollection2,
        ]);
    }

    // تقارير المبيعات
    public function FilterItems(Request $request)
    {
        $orders = Invoices::where('status', '!=', '3')->whereBetween('created_at', [$request->from, $request->to])
            ->get();

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
            // 'customers' => $customers,
        ]);
    }

    public function FilterItemsPurchases(Request $request)
    {
        // return $request;
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

    public function POS()
    {
        $products = Items::all();
        $products->each(function($item){
            $item->category =  CategoryItems::find($item->group)->namear;
            $item->price =  Itemslist::where('itemId', $item->id)->get()[0]->price1;
            $item->list =  Itemslist::where('itemId', $item->id)->get();
        });
        $stores = StoreModel::all();
        $customers = Customers::all();
        $groups = CategoryItems::all();

        return response()->json([
            'products'=> $products,
            'stores'=> $stores,
            'customers'=> $customers,
            'groups'=> $groups,
        ]);
    }

    public function getItemsGroups($id)
    {
        $products = Items::where('group', $id)->get();
        $products->each(function($item){
            $item->category =  CategoryItems::find($item->group)->namear;
            $item->price =  Itemslist::where('itemId', $item->id)->get()[0]->price1;
            $item->list =  Itemslist::where('itemId', $item->id)->get();
        });
        return response()->json([
            'products'=> $products,
        ]);
    }

    public function savePos(Request $request)
    {
            // return $request->status;
            $acc = Customers::find($request->customerId);
            $user = User::where('name', $request->username)->get()->first();
            // return $request;
            $comapny = Compaines::all()->first();
            $branch = Branches::find($user->barnchId);
            $shift = Shift::orderBy('id', 'desc')->first();
            // return $request;
            $company = Compaines::all()->first();


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
                            return $check = $this->getQtn($item['itemId'], $item['unitId'], $item['storeId']);
                            // return response()->json(["id"=>$check]);
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
                    'netTotal' => $netTotalList,
                    'customerId' => $request->customerId,
                    'visa' => $visa,
                    'storeId'=>$request->storeId,
                    'credit' => $credit,
                    'masterCard' => $masterCard,
                    'cash' => $cash,
                    // 'status_type' => $statusType,
                    'tab' => $tab,
                ]);

                if ($request->priceDeleiver && $request->priceDeleiver != 0) {
                    $invoice->deleiver = $request->priceDeleiver;
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
                    $this->createCuff($request, $acc, $netTotalList, $invoice, $taxs, $average_total, $totals, $branch);
                }
                $list = SavedInvoices::where('invoiceId', $invoice->id)->get();

                // if(isset($request->isPrint) && $request->isPrint == "true") {
                    // $this->print($request, $invoice->id, $invoice, $totals, $taxs);
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

     // انشاء القيود
    public function createCuff($data, $account, $netTotalList = 0, $invoice, $taxs, $average_total, $totals, $branch)
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
        $priceDeleiverD = 0;
        if ($data->priceDeleiver) {
            $priceDeleiverD = $data->priceDeleiver;
        }
        $company = Compaines::all()->first();


        $idIn = DailyRestrictions::create([
            'id' => $id,
            'fiscal_year' => $fiscal_year->code,
            'document' => '',
            'description' => '',
            'branshId' => $branch->id,
            'source' => $invoice->id,
            'source_name' => 'مبيعات',
            'creditor' => $netTotalList - $val + $priceDeleiverD,
            'debtor' => $netTotalList - $val + $priceDeleiverD,
        ]);

        // هيتضاف علية التوصيل
        if ($data->status == 1 || $data->status == 10 || $data->status == 4) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotalList - $val + $priceDeleiverD,
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
            if ($company->tobacco_tax == 1){
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 56,
                    'account_name' => 'ضريبة تبغ',
                    'debtor' => $netTotalList,
                    'creditor' => 0,
                    'description' => '',
                ]);
            }
            //
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => 39,
                'account_name' => 'الصندوق',
                'debtor' => $netTotalList - $val + $priceDeleiverD,
                'creditor' => 0,
                'description' => '',
            ]);
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => 0,
                'creditor' => $netTotalList - $val + $priceDeleiverD,
                'description' => '',
            ]);
        }


        if ($data->status == 2) {
            DailyRestrictionsList::create([
                'invoice_id' => $idIn->id,
                'account_id' => $account->account_id,
                'account_name' => $account->name,
                'debtor' => $netTotalList - $val + $priceDeleiverD,
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
                    'creditor' => $taxs,
                    'description' => '',
                ]);
            }


            if ($company->tobacco_tax == 1){
                DailyRestrictionsList::create([
                    'invoice_id' => $idIn->id,
                    'account_id' => 56,
                    'account_name' => 'ضريبة تبغ',
                    'debtor' => $netTotalList,
                    'creditor' => 0,
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


}
