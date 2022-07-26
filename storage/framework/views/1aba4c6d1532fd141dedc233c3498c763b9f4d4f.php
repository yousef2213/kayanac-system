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
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('home')); ?>">
        <img src="<?php echo e(asset('assets/kayanac-v-2.png')); ?>" width="120" alt="">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link text-right" href="<?php echo e(route('home')); ?>">
            <span class="mr-3 font-main"> <?php echo e(__('app.panacl')); ?> </span>
            <i class="fas fa-fw fa-tachometer-alt"></i>
        </a>

    </li>

    <div class="sidebar-heading font-main text-right <?php echo e($user->TsSystem == 0 ? 'd-none' : ''); ?>">
        النظام
    </div>

    <?php $permision = DB::table('reference')->first(); ?>


    <?php if($permision->system == 1): ?>
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsSystem == 0 ? 'd-none' : ''); ?>" id="system-12345"
                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false">
                <span class="font-main mr-3"> <?php echo e(__('app.system')); ?> </span>
                <i class="fas fa-image"></i>
            </a>
            <div id="collapseTwo"
                class="collapse <?php echo e(Request::path() == "$lang/home" ||
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
                    : ''); ?>"
                aria-labelledby="system-12345" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">System Options:</h6>
                    


                    <a class="<?php echo e($user->TsCompany == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/compaines" ? 'active' : ''); ?>"
                        href="<?php echo e(route('compaines.index')); ?>"> <?php echo e(__('app.comp')); ?> </a>
                    <a class="<?php echo e($user->TsBranchs == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/branches" ? 'active' : ''); ?>"
                        href="<?php echo e(route('branches.index')); ?>"> <?php echo e(__('app.bran')); ?> </a>
                    <a class="<?php echo e($user->TsFiscalYears == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/fiscal_years" ? 'active' : ''); ?>"
                        href="<?php echo e(route('fiscal_years.index')); ?>"> السنوات المالية </a>
                    <a class="<?php echo e($user->TsCurrencies == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/currencies" ? 'active' : ''); ?>"
                        href="<?php echo e(route('currencies.index')); ?>"> العملات </a>
                    <a class="<?php echo e($user->TsUsers == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/users" ? 'active' : ''); ?>"
                        href="<?php echo e(route('users.index')); ?>"> <?php echo e(__('pos.users')); ?> </a>
                    <a class="<?php echo e($user->TsEmployees == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/employees" ? 'active' : ''); ?>"
                        href="<?php echo e(route('employees.index')); ?>"> الموظفين </a>
                    <a class="<?php echo e($user->TsCustomers == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/customers" ? 'active' : ''); ?>"
                        href="<?php echo e(route('customers.index')); ?>"> <?php echo e(__('pos.customers')); ?> </a>
                    <a class="<?php echo e($user->TsSuppliers == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/supplier" ? 'active' : ''); ?>"
                        href="<?php echo e(route('supplier.index')); ?>"> <?php echo e(__('pos.suppliers')); ?> </a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if($permision->stores == 1): ?>
        <!-- stores -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsStores == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true"
                aria-controls="categoryCollapse">
                <span class="font-main mr-3">المخازن</span>
                <i class="fas fa-sitemap"></i>
            </a>
            <div id="categoryCollapse"
                class="collapse <?php echo e(Request::path() == "$lang/items" ||
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
                    : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Store Options:</h6>
                    <a class="<?php echo e($user->TsCategoryCard == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/item_movement" ? 'active' : ''); ?> "
                        href="<?php echo e(route('item_movement.index')); ?>"> كارت الصنف </a>
                    <a class="<?php echo e($user->TsItems == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/items" ? 'active' : ''); ?> "
                        href="<?php echo e(route('items.index')); ?>"> الاصناف </a>
                    <a class="<?php echo e($user->TsCollectionOfItems == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/collections" ? 'active' : ''); ?>"
                        href="<?php echo e(route('collections.index')); ?>"> التجميع </a>
                    <a class="<?php echo e($user->TsUnits == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/units" ? 'active' : ''); ?>"
                        href=<?php echo e(route('units')); ?>> الوحدات </a>
                    <a class="<?php echo e($user->TsGroupItems == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/categories-of-items" ? 'active' : ''); ?> "
                        href="<?php echo e(route('item.index.categories')); ?>"> مجموعة الاصناف </a>
                    <a class="<?php echo e($user->TsStoresOpeningBalance == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/opening_balance" ? 'active' : ''); ?> "
                        href="<?php echo e(route('opening_balance.index')); ?>"> رصيد افتتاحي </a>
                    <a class="<?php echo e($user->TsDefinitionStores == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/stores" ? 'active' : ''); ?>"
                        href="<?php echo e(route('stores.index')); ?>"> تعريف المخازن </a>
                    <a class="<?php echo e($user->TsTransfersStores == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/Transfers" ? 'active' : ''); ?>"
                        href="<?php echo e(route('Transfers.index')); ?>"> تحويلات المخازن </a>
                    <a class="<?php echo e($user->TsOrderAdd == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/permission_add" ? 'active' : ''); ?>"
                        href="<?php echo e(route('permission_add.index')); ?>"> اذن اضافة </a>
                    <a class="<?php echo e($user->TsOrderCashing == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/permission_cashing" ? 'active' : ''); ?>"
                        href="<?php echo e(route('permission_cashing.index')); ?>"> اذن صرف </a>
                    <a class="<?php echo e($user->TsItemsBalances == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/items-balances" ? 'active' : ''); ?>"
                        href="<?php echo e(route('items-balances.index')); ?>"> ارصدة الاصناف </a>
                    <a class="<?php echo e($user->TsStoreEvaluation == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right"
                        href="<?php echo e(route('stock-valuation.index')); ?>"> تقييم المخزون </a>
                </div>
            </div>
        </li>
    <?php endif; ?>



    <?php if($permision->sales == 1): ?>
        <!-- salles -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsSales == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#salesBill" aria-expanded="true" aria-controls="salesBill">
                <span class="font-main mr-3">المبيعات</span>
                <i class="fa fa-shopping-bag"></i>
            </a>
            <div id="salesBill"
                class="collapse <?php echo e(Request::path() == "$lang/salesBill" ||
                Request::path() == "$lang/ItemsSalles" ||
                Request::path() == "$lang/offer-price" ||
                Request::path() == "$lang/sell-order" ||
                Request::path() == "$lang/sale-reports" ||
                Request::path() == "$lang/SallesReturned" ||
                Request::path() == "$lang/ItemsSallesSaved"
                    ? 'show'
                    : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="<?php echo e($user->TsSales == 0 ? 'd-none' : ''); ?> collapse-header">Sales Options:</h6>
                    <a class="<?php echo e($user->TsInvoiceSales == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/salesBill" ? 'active' : ''); ?>"
                        href="<?php echo e(route('salesBill.index')); ?>"> فاتورة المبيعات </a>
                    <a class="<?php echo e($user->TsReturnedSales == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/SallesReturned" ? 'active' : ''); ?>"
                        href="<?php echo e(route('SallesReturned.returned')); ?>"> مرتجع المبيعات </a>
                    <a class="<?php echo e($user->TsPriceOfferSalles == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == '/offer-price' ? 'active' : ''); ?> "
                        href="<?php echo e(route('offer-price.index')); ?>"> عرض سعر </a>
                    <a class="collapse-item d-none font-main text-right <?php echo e(Request::path() == '/sell-order' ? 'active' : ''); ?>"
                        href="<?php echo e(route('sell-order.index')); ?>"> امر بيع </a>
                    <a class="<?php echo e($user->TsInvoiceReports == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == '/sales-reports' ? 'active' : ''); ?>"
                        href="<?php echo e(route('SaleReports.index')); ?>"> التقارير </a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <?php if($permision->purchases == 1): ?>
        <!-- Purchases -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsPurchases == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#purchases" aria-expanded="true" aria-controls="purchases">
                <span class="font-main mr-3">المشتريات</span>
                <i class="fa fa-credit-card"></i>
            </a>
            <div id="purchases"
                class="collapse <?php echo e(Request::path() == "$lang/ItemsPurchases" ||
                Request::path() == "$lang/returnedInvoices" ||
                Request::path() == "$lang/purchase-order" ||
                Request::path() == "$lang/PurchasesItems/ReportPurchase" ||
                Request::path() == "$lang/PurchasesItems"
                    ? 'show'
                    : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Purchases Options:</h6>
                    <a class="<?php echo e($user->TsInvoicePurchases == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/ItemsPurchases" ? 'active' : ''); ?>"
                        href="<?php echo e(route('ItemsPurchases.index')); ?>"> فاتورة المشتريات </a>
                    <a class="<?php echo e($user->TsPurchasesReports == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/PurchasesItems/ReportPurchase" ? 'active' : ''); ?>"
                        href="<?php echo e(route('PurchasesItems.ReportPurchase')); ?>"> تقارير المشتريات </a>
                    <a class="<?php echo e($user->TsReturnedPurchases == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/returnedInvoices" ? 'active' : ''); ?>"
                        href="<?php echo e(route('returnedInvoices.index')); ?>"> مرتجع المشتريات </a>
                    <a class="collapse-item d-none font-main text-right <?php echo e(Request::path() == "$lang/purchase-order" ? 'active' : ''); ?>"
                        href="<?php echo e(route('purchase-order.index')); ?>"> امر شراء </a>
                    <a class="<?php echo e($user->TsReportsItemsPurchases == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/PurchasesItems" ? 'active' : ''); ?>"
                        href="<?php echo e(route('PurchasesItemsController.index')); ?>"> تقارير الاصناف </a>
                </div>
            </div>
        </li>
    <?php endif; ?>



    <?php if($permision->financial_account == 1): ?>
        <!-- Accounts -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsAccounts == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#FinancialAccounting" aria-expanded="true"
                aria-controls="FinancialAccounting">
                <span class="font-main mr-3">المحاسبة المالية</span>
                <i class="fa fa-server"></i>
            </a>
            <div id="FinancialAccounting"
                class="collapse <?php echo e(Request::path() == "$lang/accounts" ||
                Request::path() == "$lang/budget" ||
                Request::path() == "$lang/opening_balance_accounts" ||
                Request::path() == "$lang/daily_restrictions" ||
                Request::path() == "$lang/cost_centers" ||
                Request::path() == "$lang/cost_centers_reports" ||
                Request::path() == "$lang/account-statement" ||
                Request::path() == "$lang/income_list" ||
                Request::path() == "$lang/accounts-reports"
                    ? 'show'
                    : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Financial Accounting:</h6>
                    <a class="<?php echo e($user->TsAccountsGuide == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/accounts" ? 'active' : ''); ?>"
                        href="<?php echo e(route('accounts.index')); ?>"> دليل الحسابات </a>
                    <a class="<?php echo e($user->TsCostCenters == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/cost_centers" ? 'active' : ''); ?>"
                        href="<?php echo e(route('cost_centers.index')); ?>"> مراكز التكلفة </a>
                    <a class="<?php echo e($user->TsRestrictions == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/daily_restrictions" ? 'active' : ''); ?>"
                        href="<?php echo e(route('daily.index')); ?>"> قيود اليومية </a>
                    <a class="<?php echo e($user->TsOpeningAccounts == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/opening_balance_accounts" ? 'active' : ''); ?> "
                        href="<?php echo e(route('opening_balance_accounts.index')); ?>"> رصيد افتتاحي </a>
                    <a class="collapse-item font-main text-right <?php echo e(Request::path() == "$lang/financial-accounting-reports" ? 'active' : ''); ?>"
                        href="<?php echo e(route('accounts.reports')); ?>"> التقارير </a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <?php if($permision->bonds == 1): ?>
        <!-- bond -->
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsBonds == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#bond" aria-expanded="true" aria-controls="purchases">
                <span class="font-main mr-3">السندات</span>
                <i class="fa fa-address-book"></i>
            </a>
            <div id="bond"
                class="collapse <?php echo e(Request::path() == "$lang/bonds/cash_receipt_voucher" ||
                Request::path() == "$lang/bonds/bank_receipt_voucher" ||
                Request::path() == "$lang/bond/create" ||
                Request::path() == "$lang/bonds/voucher_for_cash" ||
                Request::path() == "$lang/bonds/voucher_for_bank"
                    ? 'show'
                    : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Bonds Options:</h6>
                    <a class="<?php echo e($user->TsCashReceipt == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/bonds/cash_receipt_voucher" ? 'active' : ''); ?>"
                        href="<?php echo e(route('bond.cash_receipt_voucher')); ?>"> سند قبض نقدي </a>
                    <a class="<?php echo e($user->TsCashExChange == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/bonds/voucher_for_cash" ? 'active' : ''); ?>"
                        href="<?php echo e(route('bond.voucher_for_cash')); ?>"> سند صرف نقدي </a>
                    <a class="<?php echo e($user->TsBankReceipt == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/bonds/bank_receipt_voucher" ? 'active' : ''); ?>"
                        href="<?php echo e(route('bond.bank_receipt_voucher')); ?>"> سند قبض بنكي </a>
                    <a class="<?php echo e($user->TsBankExChange == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/bonds/voucher_for_bank" ? 'active' : ''); ?>"
                        href="<?php echo e(route('bond.voucher_for_bank')); ?>"> سند صرف بنكي </a>
                </div>
            </div>
        </li>
    <?php endif; ?>


    <!-- Production -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed <?php echo e(Auth::user()->role != 3 ? 'd-none' : ''); ?>" href="#"
            data-toggle="collapse" data-target="#production" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3">الانتاج والتصنيع</span>
            <i class="fa fa-building"></i>
        </a>
        <div id="production" class="collapse <?php echo e(Request::path() == "$lang/production" ? 'show' : ''); ?>"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Production Options:</h6>
                
            </div>
        </div>
    </li>

    <!-- HR -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed <?php echo e(Auth::user()->role != 3 ? 'd-none' : ''); ?>" href="#"
            data-toggle="collapse" data-target="#HR" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> الموارد البشرية </span>
            <i class="fa fa-male" aria-hidden="true"></i>
        </a>
        <div id="HR" class="collapse <?php echo e(Request::path() == "$lang/HR" ? 'show' : ''); ?>"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">HR Options:</h6>
                
            </div>
        </div>
    </li>
    <!-- electronicinvoice -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed <?php echo e(Auth::user()->role != 3 ? 'd-none' : ''); ?>" href="#"
            data-toggle="collapse" data-target="#electronicinvoice" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> الفاتورة الالكترونية </span>
            <i class="fa fa-inbox" aria-hidden="true"></i>
        </a>
        <div id="electronicinvoice"
            class="collapse <?php echo e(Request::path() == "$lang/electronic_invoice" ? 'show' : ''); ?>"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Electronic Invoice Options:</h6>
                
            </div>
        </div>
    </li>
    <!-- CRM -->
    <li class="nav-item">
        <a class="nav-link text-right collapsed <?php echo e(Auth::user()->role != 3 ? 'd-none' : ''); ?>" href="#"
            data-toggle="collapse" data-target="#CRM" aria-expanded="true" aria-controls="purchases">
            <span class="font-main mr-3"> CRM </span>
            <i class="fas fa-comment"></i>
        </a>
        <div id="CRM"
            class="collapse <?php echo e(Request::path() == "$lang/crm-customers" || Request::path() == "$lang/crm-offer-price" ? 'show' : ''); ?>"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">CRM Options:</h6>
                <a class="collapse-item font-main text-right" href="<?php echo e(route('crm-customers.index')); ?>"> العملاء
                </a>
                <a class="collapse-item font-main text-right" href=""> عرض سعر </a>
            </div>
        </div>
    </li>



    <?php if($permision->point_of_sales == 1): ?>
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsPointOfSales == 0 ? 'd-none' : ''); ?>"
                href="#" data-toggle="collapse" data-target="#reports" aria-expanded="true"
                aria-controls="reports">
                <span class="font-main mr-3">نقاط البيع</span>
                <i class="fa fa-bell" aria-hidden="true"></i>

            </a>
            <div id="reports"
                class="collapse <?php echo e(Request::path() == "$lang/tables" ||
                Request::path() == "$lang/reports" ||
                Request::path() == "$lang/printer-setting"
                    ? 'show'
                    : ''); ?> <?php echo e(Request::path() == "$lang/reports" ? 'show' : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Point Of Sales Options:</h6>
                    <a class="collapse-item font-main text-right <?php echo e(Request::path() == "$lang/tables" ? 'active' : ''); ?>"
                        href="<?php echo e(route('tables.index')); ?>"> الطاولات </a>
                    <a class=" collapse-item font-main text-right <?php echo e(Request::path() == "$lang/reports" ? 'active' : ''); ?>"
                        href="<?php echo e(route('reports.index')); ?>"> تقرير الوردية </a>
                    <a class="<?php echo e($user->TsPrintSetting == 0 ? 'd-none' : ''); ?> collapse-item font-main text-right <?php echo e(Request::path() == "$lang/printer-setting" ? 'active' : ''); ?> "
                        href="<?php echo e(route('printer.setting')); ?>"> اعدادات الطابعة </a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <?php if($permision->setting == 1): ?>
        <li class="nav-item">
            <a class="nav-link text-right collapsed <?php echo e($user->TsSettings == 0 ? 'd-none' : ''); ?>" href="#"
                data-toggle="collapse" data-target="#version-setting" aria-expanded="true"
                aria-controls="version-setting">
                <span class="font-main mr-3"> اعدادات </span>
                <i class="fa fa-cogs" aria-hidden="true"></i>
            </a>
            <div id="version-setting" class="collapse <?php echo e(Request::path() == "$lang/setting" ? 'show' : ''); ?>"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Setting Options:</h6>
                    <a class="collapse-item font-main text-right <?php echo e(Request::path() == "$lang/setting" ? 'active' : ''); ?> "
                        href="<?php echo e(route('setting')); ?>"> تحديث اخر اصدار </a>
                </div>
            </div>
        </li>
    <?php endif; ?>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/dashboard/sidebar.blade.php ENDPATH**/ ?>