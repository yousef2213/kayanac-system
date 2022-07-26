<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Customers;
use App\DailyRestrictions;
use App\DailyRestrictionsList;
use App\Items;
use App\Itemslist;
use App\OpeningBalanceAccounts;
use App\OpeningBalanceAccountsList;
use App\OrderPages;
use App\PermissionAdd;
use App\PermissionAddList;
use App\Powers;
use App\Purchases;
use App\PurchasesList;
use App\StoreModel;
use App\Supplier;
use App\Traits\GetAccounts;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;

class OpeningBalanceAccountsController extends Controller
{
    use GetAccounts;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $invoice = OpeningBalanceAccounts::orderBy('id', 'DESC')->first();
        $show = 0;
        if (!$invoice) {
            $show = 1;
        } else {
            $invoice->branch_name = Branches::find($invoice->branchId)->namear;
        }

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsOpeningAccounts" )->first();
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
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsOpeningAccounts" )->first();
        }
        return view('OpeneningBalanceAccounts.index')->with('orders', $orders)->with('invoice', $invoice)->with('show', $show);
    }

    public function create()
    {
        $branches = Branches::all();
        $accounts = $this->accounts();
        $items = Items::all();
        return view('OpeneningBalanceAccounts.create')
            ->with('accounts', $accounts)
            ->with('items', $items)
            ->with('branches', $branches);
    }
    // done
    public function store(Request $request)
    {
        $this->validate($request, [
            'branchId' => 'required',
        ]);
        $accounts = $this->accounts();
        $debtor = 0;
        $creditor = 0;
        $list = json_decode($request->list[0], true);

        if (count($list) > 0) {
            foreach ($list as $item) {
                $deb = 0;
                $cer = 0;
                if (isset($item['debtor'])) {
                    $deb = $item['debtor'];
                }
                if (isset($item['creditor'])) {
                    $cer = $item['creditor'];
                }
                $debtor += $deb;
                $creditor += $cer;
            }
        }
        if ($debtor == $creditor) {
            $invoice = OpeningBalanceAccounts::create([
                'date' => $request->date,
                'source' => 'رصيد افتتاحي',
                'branchId' => $request->branchId,
                'creditor' => $creditor,
                'debtor' => $debtor,
            ]);

            if (count($list) > 0) {
                foreach ($list as $item) {
                    $name = collect($accounts)
                        ->where('account_id', $item['account_id'])
                        ->first();
                    $descr = '';
                    $de = 0;
                    $cr = 0;
                    if (isset($item['desc'])) {
                        $descr = $item['desc'];
                    }
                    if (isset($item['debtor'])) {
                        $de = $item['debtor'];
                    }
                    if (isset($item['creditor'])) {
                        $cr = $item['creditor'];
                    }

                    OpeningBalanceAccountsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $item['account_id'],
                        'account_name' => $name->name,
                        'debtor' => $de,
                        'creditor' => $cr,
                        'description' => $descr,
                    ]);
                }
            }
            return redirect()
                ->route('opening_balance_accounts.index')
                ->with('success', 'تم الاضافة بنجاح');
        } else {
            return redirect()
                ->back()
                ->with('faild', 'مجموع المدين يجب ان يساوي مجموع الدائن');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $branches = Branches::all();
        $accounts = $this->accounts();
        $items = Items::all();
        $invoice = OpeningBalanceAccounts::find(1);
        $invoicesList = OpeningBalanceAccountsList::where('invoice_id', 1)->get();
        $debtors = 0;
        $credetors = 0;
        foreach ($invoicesList as $item) {
            $debtors += $item->debtor;
            $credetors += $item->creditor;
        }
        // return $credetors;
        return view('OpeneningBalanceAccounts.edit')
            ->with('accounts', $accounts)
            ->with('items', $items)
            ->with('invoice', $invoice)
            ->with('invoicesList', $invoicesList)
            ->with('branches', $branches)
            ->with('debtors', $debtors)
            ->with('credetors', $credetors);
    }

    public function update(Request $request, $id)
    {
        $list = json_decode($request->list[0], true);
        $debtor = 0;
        $creditor = 0;
        $list = json_decode($request->list[0], true);
        // return $list;
        if (count($list) > 0) {
            foreach ($list as $item) {
                $deb = 0;
                $cer = 0;
                if (isset($item['debtor'])) {
                    $deb = $item['debtor'];
                }
                if (isset($item['creditor'])) {
                    $cer = $item['creditor'];
                }
                $debtor += $deb;
                $creditor += $cer;
            }
        }

        if ($debtor != $creditor) {
            return redirect()
                ->back()
                ->with('faild', 'مجموع المدين يجب ان يساوي مجموع الدائن');
        }

        $invoice = OpeningBalanceAccounts::find($id);
        $accounts = $this->accounts();
        $deT = 0;
        $crT = 0;
        if (count($list) > 0) {
            foreach ($list as $item) {
                if ($item['isNew'] == true) {
                    $name = collect($accounts)->where('account_id', $item['account_id'])->first();
                    $descr = '';
                    $de = 0;
                    $cr = 0;
                    if (isset($item['description'])) {
                        $descr = $item['description'];
                    }
                    if (isset($item['debtor'])) {
                        $de = $item['debtor'];
                        $deT += $item['debtor'];
                    }
                    if (isset($item['creditor'])) {
                        $cr = $item['creditor'];
                        $crT += $item['creditor'];
                    }

                    OpeningBalanceAccountsList::create([
                        'invoice_id' => $invoice->id,
                        'account_id' => $item['account_id'],
                        'account_name' => $name->name,
                        'debtor' => $de,
                        'creditor' => $cr,
                        'description' => $descr,
                    ]);
                } else {
                    $itemUpdate = OpeningBalanceAccountsList::find($item['id']);
                    $name2 = collect($accounts)
                        ->where('account_id', $item['account_id'])
                        ->first();
                    if ($item['account_id']) {
                        if (isset($name2->account_id)) {
                            $itemUpdate->account_id = $name2->account_id;
                        } else {
                            $itemUpdate->account_id = $name2['id'];
                        }
                        $itemUpdate->account_name = $name2['name'];
                        $itemUpdate->save();
                    }
                    if ($item['debtor']) {
                        $itemUpdate->debtor = $item['debtor'];
                        $deT += $item['debtor'];
                        $itemUpdate->save();
                    }
                    if ($item['creditor']) {
                        $itemUpdate->creditor = $item['creditor'];
                        $crT += $item['creditor'];
                        $itemUpdate->save();
                    }
                    if ($item['description']) {
                        $itemUpdate->description = $item['description'];
                        $itemUpdate->save();
                    }
                }
            }
        }



        $invoice->branchId = $request->branchId;
        $invoice->debtor = $deT;
        $invoice->creditor = $crT;
        $invoice->save();

        return redirect()->route('opening_balance_accounts.index');
    }

    public function destroy($id)
    {
        $invoice = OpeningBalanceAccounts::find($id);
        $purchaseList = OpeningBalanceAccountsList::where('invoice_id', $id)->get();
        if (count($purchaseList) > 0) {
            foreach ($purchaseList as $purchaseItem) {
                $purchaseItem->delete();
            }
        }
        if ($invoice) {
            $invoice->delete();
        }

        return redirect()
            ->route('opening_balance_accounts.index')
            ->with('msg', 'تم الحذف بنجاح');
    }



    public function destroyRow($id)
    {
        $item = OpeningBalanceAccountsList::find($id);
        $item->delete();
        return response()->json([
            "status" => 200,
            'id' => $id
        ]);
    }
}
