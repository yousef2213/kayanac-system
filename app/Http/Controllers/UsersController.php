<?php

namespace App\Http\Controllers;

use App\Branches;
use App\OrderPages;
use App\Pages;
use App\Powers;
use App\RefUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
        $this->middleware('permision:TsUsers');
    }

    public function index()
    {
        $users = User::paginate(10);
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsUsers" )->first();
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


            $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsUsers" )->first();

        }
        return view('users.index')->with('users', $users)->with('orders', $orders);
    }

    public function create()
    {

         // $ref = RefUser::all()->first();
        // $users = User::all();
        // if ($ref->ref == 1 || $ref->ref == 2 || $ref->ref == 3) {
        //     if (count($users) >= 1) {
        //         if ($ref->ref == 1) $name =  "برونز ";
        //         if ($ref->ref == 2) $name =  "سيلفر ";
        //         if ($ref->ref == 3) $name =  "جولد ";
        //         return redirect()->route('users.index')->with('msg', "لا يمكن اضافة يوزر اخر انت علي نسخة  " . $name);
        //     }
        // }
        $branches = Branches::all();
        $parents = Pages::where('parent', '=', 1)->get();
        $childs = Pages::where('parent', '!=', 1)->get();
        return view('users.create')
                ->with('branches', $branches)
                ->with('parents', $parents)
                ->with('childs', $childs);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|unique:users',
            'password' => ['required', 'string', 'confirmed'],
            "barnchId" => "required",
        ]);
        $columns = \Schema::getColumnListing('powers');

        $last_id = 0;
        $lastUser = User::all()->last();
        if ($lastUser) {
            $last_id = $lastUser->id + 1;
        }
        $user = User::create([
            "id" => $last_id,
            "name" => $request->name,
            "role" => $request->type,
            "barnchId" => $request->barnchId,
            "password" => Hash::make($request->password),
        ]);

        if(isset($request->email) && $request->email != ""){
            $user->email = $request->email;
            $user->save();
        }


        if ($user) {
            $data['user_id'] = $last_id;
            $power = Powers::create($data);


            if($request->type == 3){
                foreach ($columns as $column) {
                    if($column != "id" && $column != "user_id"){
                        $power[$column] = 1;
                        $power->save();
                    }
                }
                foreach ($columns as $column) {
                    if($column != "id" && $column != "user_id"){
                        OrderPages::create([
                            'user_id' => $last_id,
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
                            'user_id' => $last_id,
                            "power_name" => $column,
                            "show" => 0,
                            "add" => 0,
                            "edit" => 0,
                            "delete" => 0,
                        ]);
                    }
                }

                    if ($request->TsSystem) {
                        $power->TsSystem = $request->TsSystem;
                    } else {
                        $power->TsSystem = 0;
                    }
                    // system
                    if ($request->TsCompany) {
                        $power->TsCompany = $request->TsCompany;
                    } else {
                        $power->TsCompany = 0;
                    }
                    if ($request->TsBranchs) {
                        $power->TsBranchs = $request->TsBranchs;
                    } else {
                        $power->TsBranchs = 0;
                    }
                    if ($request->TsFiscalYears) {
                        $power->TsFiscalYears = $request->TsFiscalYears;
                    } else {
                        $power->TsFiscalYears = 0;
                    }
                    // التقييم
                    if ($request->TsItemsBalances) {
                        $power->TsItemsBalances = $request->TsItemsBalances;
                    } else {
                        $power->TsItemsBalances = 0;
                    }
                    // تقييم المخزون
                    if ($request->TsStoreEvaluation) {
                        $power->TsStoreEvaluation = $request->TsStoreEvaluation;
                    } else {
                        $power->TsStoreEvaluation = 0;
                    }
                    // تجميع الاصناف
                    if ($request->TsCollectionOfItems) {
                        $power->TsCollectionOfItems = $request->TsCollectionOfItems;
                    } else {
                        $power->TsCollectionOfItems = 0;
                    }
                    // تحويل المخازن
                    if ($request->TsTransfersStores) {
                        $power->TsTransfersStores = $request->TsTransfersStores;
                    } else {
                        $power->TsTransfersStores = 0;
                    }



                    if ($request->TsCurrencies) {
                        $power->TsCurrencies = $request->TsCurrencies;
                    } else {
                        $power->TsCurrencies = 0;
                    }
                    if ($request->TsUsers) {
                        $power->TsUsers = $request->TsUsers;
                    } else {
                        $power->TsUsers = 0;
                    }
                    if ($request->TsCustomers) {
                        $power->TsCustomers = $request->TsCustomers;
                    } else {
                        $power->TsCustomers = 0;
                    }
                    if ($request->TsSuppliers) {
                        $power->TsSuppliers = $request->TsSuppliers;
                    } else {
                        $power->TsSuppliers = 0;
                    }
                    // end of system
                    // stores
                    if ($request->TsStores) {
                        $power->TsStores = $request->TsStores;
                    } else {
                        $power->TsStores = 0;
                    }
                    if ($request->TsCategoryCard) {
                        $power->TsCategoryCard = $request->TsCategoryCard;
                    } else {
                        $power->TsCategoryCard = 0;
                    }
                    if ($request->TsItems) {
                        $power->TsItems = $request->TsItems;
                    } else {
                        $power->TsItems = 0;
                    }
                    if ($request->TsUnits) {
                        $power->TsUnits = $request->TsUnits;
                    } else {
                        $power->TsUnits = 0;
                    }
                    if ($request->TsUnits) {
                        $power->TsUnits = $request->TsUnits;
                    } else {
                        $power->TsUnits = 0;
                    }
                    if ($request->TsStoresOpeningBalance) {
                        $power->TsStoresOpeningBalance = $request->TsStoresOpeningBalance;
                    } else {
                        $power->TsStoresOpeningBalance = 0;
                    }
                    if ($request->TsStoresOpeningBalance) {
                        $power->TsStoresOpeningBalance = $request->TsStoresOpeningBalance;
                    } else {
                        $power->TsStoresOpeningBalance = 0;
                    }
                    if ($request->TsOrderAdd) {
                        $power->TsOrderAdd = $request->TsOrderAdd;
                    } else {
                        $power->TsOrderAdd = 0;
                    }
                    if ($request->TsOrderCashing) {
                        $power->TsOrderCashing = $request->TsOrderCashing;
                    } else {
                        $power->TsOrderCashing = 0;
                    }
                    // end of stores

                    // sales
                    if ($request->TsSales) {
                        $power->TsSales = $request->TsSales;
                    } else {
                        $power->TsSales = 0;
                    }
                    if ($request->TsInvoiceSales) {
                        $power->TsInvoiceSales = $request->TsInvoiceSales;
                    } else {
                        $power->TsInvoiceSales = 0;
                    }
                    if ($request->TsInvoiceReports) {
                        $power->TsInvoiceReports = $request->TsInvoiceReports;
                    } else {
                        $power->TsInvoiceReports = 0;
                    }
                    if ($request->TsReturnedSales) {
                        $power->TsReturnedSales = $request->TsReturnedSales;
                    } else {
                        $power->TsReturnedSales = 0;
                    }
                    if ($request->TsReportsItemsSals) {
                        $power->TsReportsItemsSals = $request->TsReportsItemsSals;
                    } else {
                        $power->TsReportsItemsSals = 0;
                    }
                    // end of sales


                    if ($request->TsPurchases) {
                        $power->TsPurchases = $request->TsPurchases;
                    } else {
                        $power->TsPurchases = 0;
                    }
                    if ($request->TsAccounts) {
                        $power->TsAccounts = $request->TsAccounts;
                    } else {
                        $power->TsAccounts = 0;
                    }
                    if ($request->TsBonds) {
                        $power->TsBonds = $request->TsBonds;
                    } else {
                        $power->TsBonds = 0;
                    }
                    // if ($request->TsReports) {
                    //     $power->TsReports = $request->TsReports;
                    // } else {
                    //     $power->TsReports = 0;
                    // }
                    if ($request->TsSettings) {
                        $power->TsSettings = $request->TsSettings;
                    } else {
                        $power->TsSettings = 0;
                    }
                    if ($request->TsPrintSetting) {
                        $power->TsPrintSetting = $request->TsPrintSetting;
                    } else {
                        $power->TsPrintSetting = 0;
                    }
                    $power->save();
            }



        }

        return redirect()->route('users.index')->with("msg", 'User Created Successfuly ');
    }


    public function show($id)
    {
        //
    }


    public function permision($id)
    {
        $parents = Pages::where('parent', '=', 1)->get();
        $childs = Pages::where('parent', '!=', 1)->get();
        $power = Powers::where('user_id', '=', $id)->first();
        $orders = OrderPages::where('user_id', '=', $id)->get();
        $user = User::findOrFail($id);

        $powers = collect($power);
        $powersCollection = [];
        foreach ($powers as $key => $value) {
            if($powers[$key] == 1){
                $powersCollection[$key] = $value;
            }
        }
        $namePowers = [];
        $data = collect($powersCollection)->except('user_id','id','TsPointOfSales','TsPos','TsBackup','TsTablesResturant','TsReportsItemsPurchases','TsShiftReport','TsAccountStatement','TsBudgetReport','TsCostCenterReport');
        foreach ($data as $key => $value) {
            $namePowers[] = Pages::where('page_name', $key)->first();
        }
        $childs = $namePowers;
        // return $powersCollection;
        return view('users.UserPermision')
            ->with('user', $user)
            ->with('parents', $parents)
            ->with('childs', $childs)
            ->with('orders', $orders)
            ->with('power', $power);
    }


    public function edit($id)
    {
        $parents = Pages::where('parent', '=', 1)->get();
        $childs = Pages::where('parent', '!=', 1)->get();
        $power = Powers::where('user_id', '=', $id)->first();
        $user = User::findOrFail($id);
        // return $power;
        return view('users.edit')->with('user', $user)->with('parents', $parents)->with('childs', $childs)->with('power', $power);
    }

    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'password' => ['required', 'string', 'confirmed'],
        // ]);
        // return $request;
        $user = User::find($id);
        $user->name = $request->name;
        $user->status = $request->status;
        $user->role = $request->role;
        // return $request;
        if ($request->password) {
            $user->password = Hash::make($request['password']);
            $user->save();
        }

        $data = $request->except('_token', '_method', 'name', 'email', 'password', 'password_confirmation', 'role', 'status');
        // return array($data);
        if ($user) {
            $powerUser = Powers::where('user_id', $id)->first();
            if ($request->TsSystem) {
                $powerUser->TsSystem = $request->TsSystem;
            } else {
                $powerUser->TsSystem = 0;
            }
            if ($request->TsDefinitionStores) {
                $powerUser->TsDefinitionStores = $request->TsDefinitionStores;
            } else {
                $powerUser->TsDefinitionStores = 0;
            }
            if ($request->TsGroupItems) {
                $powerUser->TsGroupItems = $request->TsGroupItems;
            } else {
                $powerUser->TsGroupItems = 0;
            }

            if ($request->TsPriceOfferSalles) {
                $powerUser->TsPriceOfferSalles = $request->TsPriceOfferSalles;
            } else {
                $powerUser->TsPriceOfferSalles = 0;
            }if ($request->TsInvoicePurchases) {
                $powerUser->TsInvoicePurchases = $request->TsInvoicePurchases;
            } else {
                $powerUser->TsInvoicePurchases = 0;
            }if ($request->TsPurchasesReports) {
                $powerUser->TsPurchasesReports = $request->TsPurchasesReports;
            } else {
                $powerUser->TsPurchasesReports = 0;
            }if ($request->TsReturnedPurchases) {
                $powerUser->TsReturnedPurchases = $request->TsReturnedPurchases;
            } else {
                $powerUser->TsReturnedPurchases = 0;
            }

            // دليل الحسابات
            if ($request->TsAccountsGuide) {
                $powerUser->TsAccountsGuide = $request->TsAccountsGuide;
            } else {
                $powerUser->TsAccountsGuide = 0;
            } if ($request->TsCostCenters) {
                $powerUser->TsCostCenters = $request->TsCostCenters;
            } else {
                $powerUser->TsCostCenters = 0;
            }if ($request->TsRestrictions) {
                $powerUser->TsRestrictions = $request->TsRestrictions;
            } else {
                $powerUser->TsRestrictions = 0;
            }if ($request->TsOpeningAccounts) {
                $powerUser->TsOpeningAccounts = $request->TsOpeningAccounts;
            } else {
                $powerUser->TsOpeningAccounts = 0;
            }

            // السندات
            if ($request->TsCashReceipt) {
                $powerUser->TsCashReceipt = $request->TsCashReceipt;
            } else {
                $powerUser->TsCashReceipt = 0;
            }
            if ($request->TsCashExChange) {
                $powerUser->TsCashExChange = $request->TsCashExChange;
            } else {
                $powerUser->TsCashExChange = 0;
            }
            if ($request->TsBankReceipt) {
                $powerUser->TsBankReceipt = $request->TsBankReceipt;
            } else {
                $powerUser->TsBankReceipt = 0;
            }
            if ($request->TsBankExChange) {
                $powerUser->TsBankExChange = $request->TsBankExChange;
            } else {
                $powerUser->TsBankExChange = 0;
            }






            if ($request->TsPos) {
                $powerUser->TsPos = $request->TsPos;
            } else {
                $powerUser->TsPos = 0;
            }
            // system
            if ($request->TsCompany) {
                $powerUser->TsCompany = $request->TsCompany;
            } else {
                $powerUser->TsCompany = 0;
            }
            if ($request->TsBranchs) {
                $powerUser->TsBranchs = $request->TsBranchs;
            } else {
                $powerUser->TsBranchs = 0;
            }
            if ($request->TsFiscalYears) {
                $powerUser->TsFiscalYears = $request->TsFiscalYears;
            } else {
                $powerUser->TsFiscalYears = 0;
            }
            if ($request->TsCurrencies) {
                $powerUser->TsCurrencies = $request->TsCurrencies;
            } else {
                $powerUser->TsCurrencies = 0;
            }
            if ($request->TsUsers) {
                $powerUser->TsUsers = $request->TsUsers;
            } else {
                $powerUser->TsUsers = 0;
            }
            if ($request->TsCustomers) {
                $powerUser->TsCustomers = $request->TsCustomers;
            } else {
                $powerUser->TsCustomers = 0;
            }
            if ($request->TsSuppliers) {
                $powerUser->TsSuppliers = $request->TsSuppliers;
            } else {
                $powerUser->TsSuppliers = 0;
            }
            // end of system
            // stores
            if ($request->TsStores) {
                $powerUser->TsStores = $request->TsStores;
            } else {
                $powerUser->TsStores = 0;
            }
            if ($request->TsCategoryCard) {
                $powerUser->TsCategoryCard = $request->TsCategoryCard;
            } else {
                $powerUser->TsCategoryCard = 0;
            }
            if ($request->TsItems) {
                $powerUser->TsItems = $request->TsItems;
            } else {
                $powerUser->TsItems = 0;
            }
            if ($request->TsUnits) {
                $powerUser->TsUnits = $request->TsUnits;
            } else {
                $powerUser->TsUnits = 0;
            }
            if ($request->TsUnits) {
                $powerUser->TsUnits = $request->TsUnits;
            } else {
                $powerUser->TsUnits = 0;
            }
            if ($request->TsStoresOpeningBalance) {
                $powerUser->TsStoresOpeningBalance = $request->TsStoresOpeningBalance;
            } else {
                $powerUser->TsStoresOpeningBalance = 0;
            }
            if ($request->TsStoresOpeningBalance) {
                $powerUser->TsStoresOpeningBalance = $request->TsStoresOpeningBalance;
            } else {
                $powerUser->TsStoresOpeningBalance = 0;
            }
            if ($request->TsOrderAdd) {
                $powerUser->TsOrderAdd = $request->TsOrderAdd;
            } else {
                $powerUser->TsOrderAdd = 0;
            }
            if ($request->TsOrderCashing) {
                $powerUser->TsOrderCashing = $request->TsOrderCashing;
            } else {
                $powerUser->TsOrderCashing = 0;
            }
            // end of stores

            // sales
            if ($request->TsSales) {
                $powerUser->TsSales = $request->TsSales;
            } else {
                $powerUser->TsSales = 0;
            }
            if ($request->TsInvoiceSales) {
                $powerUser->TsInvoiceSales = $request->TsInvoiceSales;
            } else {
                $powerUser->TsInvoiceSales = 0;
            }
            if ($request->TsInvoiceReports) {
                $powerUser->TsInvoiceReports = $request->TsInvoiceReports;
            } else {
                $powerUser->TsInvoiceReports = 0;
            }
            if ($request->TsReturnedSales) {
                $powerUser->TsReturnedSales = $request->TsReturnedSales;
            } else {
                $powerUser->TsReturnedSales = 0;
            }
            if ($request->TsReportsItemsSals) {
                $powerUser->TsReportsItemsSals = $request->TsReportsItemsSals;
            } else {
                $powerUser->TsReportsItemsSals = 0;
            }
            // end of sales


            if ($request->TsPurchases) {
                $powerUser->TsPurchases = $request->TsPurchases;
            } else {
                $powerUser->TsPurchases = 0;
            }
            if ($request->TsAccounts) {
                $powerUser->TsAccounts = $request->TsAccounts;
            } else {
                $powerUser->TsAccounts = 0;
            }
            if ($request->TsBonds) {
                $powerUser->TsBonds = $request->TsBonds;
            } else {
                $powerUser->TsBonds = 0;
            }
            // if ($request->TsReports) {
            //     $powerUser->TsReports = $request->TsReports;
            // } else {
            //     $powerUser->TsReports = 0;
            // }
            if ($request->TsSettings) {
                $powerUser->TsSettings = $request->TsSettings;
            } else {
                $powerUser->TsSettings = 0;
            }
            if ($request->TsPrintSetting) {
                $powerUser->TsPrintSetting = $request->TsPrintSetting;
            } else {
                $powerUser->TsPrintSetting = 0;
            }


            if ($request->TsStoreEvaluation) {
                $powerUser->TsStoreEvaluation = $request->TsStoreEvaluation;
            } else {
                $powerUser->TsStoreEvaluation = 0;
            }

            if ($request->TsItemsBalances) {
                $powerUser->TsItemsBalances = $request->TsItemsBalances;
            } else {
                $powerUser->TsItemsBalances = 0;
            }

            if ($request->TsTransfersStores) {
                $powerUser->TsTransfersStores = $request->TsTransfersStores;
            } else {
                $powerUser->TsTransfersStores = 0;
            }
            if ($request->TsCollectionOfItems) {
                $powerUser->TsCollectionOfItems = $request->TsCollectionOfItems;
            } else {
                $powerUser->TsCollectionOfItems = 0;
            }




            $powerUser->save();
        }
        $user->save();
        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('photo')->move(public_path('storage/photos/1/users'), $fileNameToStore);

            $user->photo = $fileNameToStore;
            $user->save();
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        return redirect()->route('users.index')->with('msg', 'Successfully updated');
    }

    public function updateSide(Request $request, $id)
    {
        // $this->validate($request, [
        //     'password' => ['required', 'string', 'confirmed'],
        // ]);
        // return $request;
        $user = User::find($id);
        $user->name = $request->name;
        $user->status = $request->status;
        $user->role = $request->role;
        // return $request;


        $data = $request->except('_token', '_method', 'name', 'email', 'password', 'password_confirmation', 'role', 'status');
        // return $data;
        foreach ($data as $key=>$item) {
            $addSearch = "add-";
            $editSearch = "edit-";
            $delSearch = "delete-";
            // return $item;
            $str = str_contains($key, $addSearch);
            if($str) {
                $last = preg_replace('/add-/', '', $key);
            }
            if(!$str){
                $str = str_contains($key, $editSearch);
                if($str) {
                    $last = preg_replace('/edit-/', '', $key);
                }
            }
            if(!$str){
                $str = str_contains($key, $delSearch);
                if($str) {
                    $last = preg_replace('/delete-/', '', $key);
                }
            }

            $order = OrderPages::where('power_name', $last)->where('user_id', $id)->first();

            $check = mb_substr($key, 0,2);
            if($check == "ad"){
                $order->add = $item;
                $order->save();
            }
            if($check == "ed"){
                $order->edit = $item;
                $order->save();
            }
            if($check == "de"){
                $order->delete = $item;
                $order->save();
            }
        }


        return redirect()->route('users.index')->with('msg', 'Successfully updated');
    }

    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $power = Powers::where("user_id", $id)->get()->first();
        $orders = OrderPages::where("user_id", $id)->get();
        foreach ($orders as $value) {
            $value->delete();
        }
        $status = $delete->delete();



        $power->delete();
        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
