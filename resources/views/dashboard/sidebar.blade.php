<style>
    .navbar-nav.toggled>li>a,
    .navbar-nav.toggled>li>a>span,
    .navbar-nav.toggled>li .navbar-nav.toggled>.head {
        text-align: center !important
    }

    a.active {
        color: #212529 !important;
        background-color: #e2e6ea !important;
        border-color: #dae0e5 !important;
    }
</style>

<?php
$user = DB::table('powers')
    ->where('user_id', Auth::user()->id)
    ->first();
$lang = LaravelLocalization::getCurrentLocale();
?>


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <img src="{{ asset('assets/kayanac-v-2.png') }}" width="120" alt="">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link text-right" href="{{ route('home') }}">
            <span class="mr-3 font-main"> {{ __('app.panacl') }} </span>
            <i class="fas fa-fw fa-tachometer-alt"></i>
        </a>

    </li>

    <div class="sidebar-heading font-main text-right {{ $user->TsSystem == 0 ? 'd-none' : '' }}">
        النظام
    </div>

    <?php $permision = DB::table('reference')->first(); ?>


    @if ($permision->system == 1)
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsSystem == 0 ? 'd-none' : '' }}" id="system-12345"
                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false">
                <span class="font-main mr-3"> {{ __('app.system') }} </span>
                <i class="fas fa-image"></i>
            </a>
            <div id="collapseTwo"
                class="collapse {{ Request::path() == "$lang/home" ||
                Request::path() == "$lang/compaines" ||
                Request::path() == "$lang/branches" ||
                Request::path() == "$lang/users" ||
                Request::path() == "$lang/fiscal_years" ||
                Request::path() == "$lang/employees" ||
                Request::path() == "$lang/currencies" ||
                Request::path() == "$lang/customers" ||
                Request::path() == "$lang/users_permisions" ||
                Request::path() == "$lang/supplier"
                    ? 'show'
                    : '' }}"
                aria-labelledby="system-12345" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">System Options:</h6>
                    {{-- <a class="collapse-item font-main text-right {{ Request::path() == "$lang/users_permisions" ? "active" : "" }}" href="{{ route('users.permisions') }}"> صلاحيات المستخدمين </a> --}}


                    <a class="{{ $user->TsCompany == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/compaines" ? 'active' : '' }}"
                        href="{{ route('compaines.index') }}"> {{ __('app.comp') }} </a>
                    <a class="{{ $user->TsBranchs == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/branches" ? 'active' : '' }}"
                        href="{{ route('branches.index') }}"> {{ __('app.bran') }} </a>
                    <a class="{{ $user->TsFiscalYears == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/fiscal_years" ? 'active' : '' }}"
                        href="{{ route('fiscal_years.index') }}"> السنوات المالية </a>
                    <a class="{{ $user->TsCurrencies == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/currencies" ? 'active' : '' }}"
                        href="{{ route('currencies.index') }}"> العملات </a>
                    <a class="{{ $user->TsUsers == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/users" ? 'active' : '' }}"
                        href="{{ route('users.index') }}"> {{ __('pos.users') }} </a>
                    <a class="{{ $user->TsEmployees == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/employees" ? 'active' : '' }}"
                        href="{{ route('employees.index') }}"> الموظفين </a>
                    <a class="{{ $user->TsCustomers == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/customers" ? 'active' : '' }}"
                        href="{{ route('customers.index') }}"> {{ __('pos.customers') }} </a>
                    <a class="{{ $user->TsSuppliers == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/supplier" ? 'active' : '' }}"
                        href="{{ route('supplier.index') }}"> {{ __('pos.suppliers') }} </a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if ($permision->stores == 1)
        <!-- stores -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsStores == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true"
                aria-controls="categoryCollapse">
                <span class="font-main mr-3">المخازن</span>
                <i class="fas fa-sitemap"></i>
            </a>
            <div id="categoryCollapse"
                class="collapse {{ Request::path() == "$lang/items" ||
                Request::path() == "$lang/units" ||
                Request::path() == "$lang/collections" ||
                Request::path() == "$lang/Transfers" ||
                Request::path() == "$lang/items-collection" ||
                Request::path() == "$lang/assembly" ||
                Request::path() == "$lang/categories-of-items" ||
                Request::path() == "$lang/permission_add" ||
                Request::path() == "$lang/permission_cashing" ||
                Request::path() == "$lang/stores" ||
                Request::path() == "$lang/opening_balance" ||
                Request::path() == "$lang/item_movement" ||
                Request::path() == "$lang/stock-valuation" ||
                Request::path() == "$lang/items-balances"
                    ? 'show'
                    : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Store Options:</h6>
                    <a class="{{ $user->TsCategoryCard == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/item_movement" ? 'active' : '' }} "
                        href="{{ route('item_movement.index') }}"> كارت الصنف </a>
                    <a class="{{ $user->TsItems == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/items" ? 'active' : '' }} "
                        href="{{ route('items.index') }}"> الاصناف </a>
                    <a class="{{ $user->TsCollectionOfItems == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/collections" ? 'active' : '' }}"
                        href="{{ route('collections.index') }}"> التجميع </a>
                    <a class="{{ $user->TsUnits == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/units" ? 'active' : '' }}"
                        href={{ route('units') }}> الوحدات </a>
                    <a class="{{ $user->TsGroupItems == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/categories-of-items" ? 'active' : '' }} "
                        href="{{ route('item.index.categories') }}"> مجموعة الاصناف </a>
                    <a class="{{ $user->TsStoresOpeningBalance == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/opening_balance" ? 'active' : '' }} "
                        href="{{ route('opening_balance.index') }}"> رصيد افتتاحي </a>
                    <a class="{{ $user->TsDefinitionStores == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/stores" ? 'active' : '' }}"
                        href="{{ route('stores.index') }}"> تعريف المخازن </a>
                    <a class="{{ $user->TsTransfersStores == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/Transfers" ? 'active' : '' }}"
                        href="{{ route('Transfers.index') }}"> تحويلات المخازن </a>
                    <a class="{{ $user->TsOrderAdd == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/permission_add" ? 'active' : '' }}"
                        href="{{ route('permission_add.index') }}"> اذن اضافة </a>
                    <a class="{{ $user->TsOrderCashing == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/permission_cashing" ? 'active' : '' }}"
                        href="{{ route('permission_cashing.index') }}"> اذن صرف </a>
                    <a class="{{ $user->TsItemsBalances == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/items-balances" ? 'active' : '' }}"
                        href="{{ route('items-balances.index') }}"> ارصدة الاصناف </a>
                    <a class="{{ $user->TsStoreEvaluation == 0 ? 'd-none' : '' }} collapse-item font-main text-right"
                        href="{{ route('stock-valuation.index') }}"> تقييم المخزون </a>
                </div>
            </div>
        </li>
    @endif



    @if ($permision->sales == 1)
        <!-- salles -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsSales == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#salesBill" aria-expanded="true" aria-controls="salesBill">
                <span class="font-main mr-3">المبيعات</span>
                <i class="fa fa-shopping-bag"></i>
            </a>
            <div id="salesBill"
                class="collapse {{ Request::path() == "$lang/salesBill" ||
                Request::path() == "$lang/ItemsSalles" ||
                Request::path() == "$lang/offer-price" ||
                Request::path() == "$lang/sell-order" ||
                Request::path() == "$lang/sale-reports" ||
                Request::path() == "$lang/SallesReturned" ||
                Request::path() == "$lang/ItemsSallesSaved"
                    ? 'show'
                    : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="{{ $user->TsSales == 0 ? 'd-none' : '' }} collapse-header">Sales Options:</h6>
                    <a class="{{ $user->TsInvoiceSales == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/salesBill" ? 'active' : '' }}"
                        href="{{ route('salesBill.index') }}"> فاتورة المبيعات </a>
                    <a class="{{ $user->TsReturnedSales == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/SallesReturned" ? 'active' : '' }}"
                        href="{{ route('SallesReturned.returned') }}"> مرتجع المبيعات </a>
                    <a class="{{ $user->TsPriceOfferSalles == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == '/offer-price' ? 'active' : '' }} "
                        href="{{ route('offer-price.index') }}"> عرض سعر </a>
                    <a class="collapse-item d-none font-main text-right {{ Request::path() == '/sell-order' ? 'active' : '' }}"
                        href="{{ route('sell-order.index') }}"> امر بيع </a>
                    <a class="{{ $user->TsInvoiceReports == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == '/sales-reports' ? 'active' : '' }}"
                        href="{{ route('SaleReports.index') }}"> التقارير </a>
                </div>
            </div>
        </li>
    @endif

    @if ($permision->purchases == 1)
        <!-- Purchases -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsPurchases == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#purchases" aria-expanded="true" aria-controls="purchases">
                <span class="font-main mr-3">المشتريات</span>
                <i class="fa fa-credit-card"></i>
            </a>
            <div id="purchases"
                class="collapse {{ Request::path() == "$lang/ItemsPurchases" ||
                Request::path() == "$lang/returnedInvoices" ||
                Request::path() == "$lang/purchase-order" ||
                Request::path() == "$lang/PurchasesItems/ReportPurchase" ||
                Request::path() == "$lang/PurchasesItems"
                    ? 'show'
                    : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Purchases Options:</h6>
                    <a class="{{ $user->TsInvoicePurchases == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/ItemsPurchases" ? 'active' : '' }}"
                        href="{{ route('ItemsPurchases.index') }}"> فاتورة المشتريات </a>
                    <a class="{{ $user->TsPurchasesReports == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/PurchasesItems/ReportPurchase" ? 'active' : '' }}"
                        href="{{ route('PurchasesItems.ReportPurchase') }}"> تقارير المشتريات </a>
                    <a class="{{ $user->TsReturnedPurchases == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/returnedInvoices" ? 'active' : '' }}"
                        href="{{ route('returnedInvoices.index') }}"> مرتجع المشتريات </a>
                    <a class="collapse-item d-none font-main text-right {{ Request::path() == "$lang/purchase-order" ? 'active' : '' }}"
                        href="{{ route('purchase-order.index') }}"> امر شراء </a>
                    <a class="{{ $user->TsReportsItemsPurchases == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/PurchasesItems" ? 'active' : '' }}"
                        href="{{ route('PurchasesItemsController.index') }}"> تقارير الاصناف </a>
                </div>
            </div>
        </li>
    @endif



    @if ($permision->financial_account == 1)
        <!-- Accounts -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsAccounts == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#FinancialAccounting" aria-expanded="true"
                aria-controls="FinancialAccounting">
                <span class="font-main mr-3">المحاسبة المالية</span>
                <i class="fa fa-server"></i>
            </a>
            <div id="FinancialAccounting"
                class="collapse {{ Request::path() == "$lang/accounts" ||
                Request::path() == "$lang/budget" ||
                Request::path() == "$lang/opening_balance_accounts" ||
                Request::path() == "$lang/daily_restrictions" ||
                Request::path() == "$lang/cost_centers" ||
                Request::path() == "$lang/cost_centers_reports" ||
                Request::path() == "$lang/account-statement" ||
                Request::path() == "$lang/income_list" ||
                Request::path() == "$lang/accounts-reports"
                    ? 'show'
                    : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Financial Accounting:</h6>
                    <a class="{{ $user->TsAccountsGuide == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/accounts" ? 'active' : '' }}"
                        href="{{ route('accounts.index') }}"> دليل الحسابات </a>
                    <a class="{{ $user->TsCostCenters == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/cost_centers" ? 'active' : '' }}"
                        href="{{ route('cost_centers.index') }}"> مراكز التكلفة </a>
                    <a class="{{ $user->TsRestrictions == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/daily_restrictions" ? 'active' : '' }}"
                        href="{{ route('daily.index') }}"> قيود اليومية </a>
                    <a class="{{ $user->TsOpeningAccounts == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/opening_balance_accounts" ? 'active' : '' }} "
                        href="{{ route('opening_balance_accounts.index') }}"> رصيد افتتاحي </a>
                    <a class="collapse-item font-main text-right {{ Request::path() == "$lang/financial-accounting-reports" ? 'active' : '' }}"
                        href="{{ route('accounts.reports') }}"> التقارير </a>
                </div>
            </div>
        </li>
    @endif

    @if ($permision->bonds == 1)
        <!-- bond -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsBonds == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#bond" aria-expanded="true" aria-controls="purchases">
                <span class="font-main mr-3">السندات</span>
                <i class="fa fa-address-book"></i>
            </a>
            <div id="bond"
                class="collapse {{ Request::path() == "$lang/bonds/cash_receipt_voucher" ||
                Request::path() == "$lang/bonds/bank_receipt_voucher" ||
                Request::path() == "$lang/bond/create" ||
                Request::path() == "$lang/bonds/voucher_for_cash" ||
                Request::path() == "$lang/bonds/voucher_for_bank"
                    ? 'show'
                    : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Bonds Options:</h6>
                    <a class="{{ $user->TsCashReceipt == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/bonds/cash_receipt_voucher" ? 'active' : '' }}"
                        href="{{ route('bond.cash_receipt_voucher') }}"> سند قبض نقدي </a>
                    <a class="{{ $user->TsCashExChange == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/bonds/voucher_for_cash" ? 'active' : '' }}"
                        href="{{ route('bond.voucher_for_cash') }}"> سند صرف نقدي </a>
                    <a class="{{ $user->TsBankReceipt == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/bonds/bank_receipt_voucher" ? 'active' : '' }}"
                        href="{{ route('bond.bank_receipt_voucher') }}"> سند قبض بنكي </a>
                    <a class="{{ $user->TsBankExChange == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/bonds/voucher_for_bank" ? 'active' : '' }}"
                        href="{{ route('bond.voucher_for_bank') }}"> سند صرف بنكي </a>
                </div>
            </div>
        </li>
    @endif


    <!-- Production -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed {{ Auth::user()->role != 3 ? 'd-none' : '' }}" href="#"
            data-toggle="collapse" data-target="#production" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3">الانتاج والتصنيع</span>
            <i class="fa fa-building"></i>
        </a>
        <div id="production" class="collapse {{ Request::path() == "$lang/production" ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Production Options:</h6>
                {{-- <a class="collapse-item font-main text-right" href="{{ route('bond.voucher_for_bank') }}"> سند صرف بنكي </a> --}}
            </div>
        </div>
    </li>

    <!-- HR -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed {{ Auth::user()->role != 3 ? 'd-none' : '' }}" href="#"
            data-toggle="collapse" data-target="#HR" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> الموارد البشرية </span>
            <i class="fa fa-male" aria-hidden="true"></i>
        </a>
        <div id="HR" class="collapse {{ Request::path() == "$lang/HR" ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">HR Options:</h6>
                {{-- <a class="collapse-item font-main text-right" href="{{ route('bond.voucher_for_bank') }}"> سند صرف بنكي </a> --}}
            </div>
        </div>
    </li>
    <!-- electronicinvoice -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed {{ Auth::user()->role != 3 ? 'd-none' : '' }}" href="#"
            data-toggle="collapse" data-target="#electronicinvoice" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> الفاتورة الالكترونية </span>
            <i class="fa fa-inbox" aria-hidden="true"></i>
        </a>
        <div id="electronicinvoice"
            class="collapse {{ Request::path() == "$lang/electronic_invoice" ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Electronic Invoice Options:</h6>
                {{-- <a class="collapse-item font-main text-right" href="{{ route('bond.voucher_for_bank') }}"> سند صرف بنكي </a> --}}
            </div>
        </div>
    </li>
    <!-- CRM -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed {{ Auth::user()->role != 3 ? 'd-none' : '' }}" href="#"
            data-toggle="collapse" data-target="#CRM" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> CRM </span>
            <i class="fas fa-comment"></i>
        </a>
        <div id="CRM"
            class="collapse {{ Request::path() == "$lang/crm-customers" || Request::path() == "$lang/crm-offer-price" ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">CRM Options:</h6>
                <a class="collapse-item font-main text-right" href="{{ route('crm-customers.index') }}"> العملاء
                </a>
                <a class="collapse-item font-main text-right" href=""> عرض سعر </a>
            </div>
        </div>
    </li>



    @if ($permision->point_of_sales == 1)
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsPointOfSales == 0 ? 'd-none' : '' }}"
                href="#" data-toggle="collapse" data-target="#reports" aria-expanded="true"
                aria-controls="reports">
                <span class="font-main mr-3">نقاط البيع</span>
                <i class="fa fa-bell" aria-hidden="true"></i>

            </a>
            <div id="reports"
                class="collapse {{ Request::path() == "$lang/tables" ||
                Request::path() == "$lang/reports" ||
                Request::path() == "$lang/printer-setting"
                    ? 'show'
                    : '' }} {{ Request::path() == "$lang/reports" ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Point Of Sales Options:</h6>
                    <a class="collapse-item font-main text-right {{ Request::path() == "$lang/tables" ? 'active' : '' }}"
                        href="{{ route('tables.index') }}"> الطاولات </a>
                    <a class=" collapse-item font-main text-right {{ Request::path() == "$lang/reports" ? 'active' : '' }}"
                        href="{{ route('reports.index') }}"> تقرير الوردية </a>
                    <a class="{{ $user->TsPrintSetting == 0 ? 'd-none' : '' }} collapse-item font-main text-right {{ Request::path() == "$lang/printer-setting" ? 'active' : '' }} "
                        href="{{ route('printer.setting') }}"> اعدادات الطابعة </a>
                </div>
            </div>
        </li>
    @endif

    @if ($permision->setting == 1)
        <li class="nav-item">
            <a class="nav-link text-right collapsed {{ $user->TsSettings == 0 ? 'd-none' : '' }}" href="#"
                data-toggle="collapse" data-target="#version-setting" aria-expanded="true"
                aria-controls="version-setting">
                <span class="font-main mr-3"> اعدادات </span>
                <i class="fa fa-cogs" aria-hidden="true"></i>
            </a>
            <div id="version-setting" class="collapse {{ Request::path() == "$lang/setting" ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Setting Options:</h6>
                    <a class="collapse-item font-main text-right {{ Request::path() == "$lang/setting" ? 'active' : '' }} "
                        href="{{ route('setting') }}"> تحديث اخر اصدار </a>
                </div>
            </div>
        </li>
    @endif


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
