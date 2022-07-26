<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::resource('ItemsSalles', 'ItemsSalles');
    Route::resource('ItemsPurchases', 'PurchasesController');
    Route::get('getUnits/{id}', 'PurchasesController@getUnits')->name('getUnits');
    Route::get('Purchase/deleteRow/{id}', 'PurchasesController@deleteRow');

    // Transfers
    Route::resource('Transfers', 'TransfersController');
    Route::get('getUnitsTransfers/{id}/{store}', 'TransfersController@getUnitsTransfers')->name('getUnitsTransfers');
    Route::get('getStoresByBranch/{id}', 'TransfersController@getStoresByBranch')->name('getStoresByBranch');


    Route::resource('items', 'ItemsController');
    Route::resource('collections', 'CollectionsController');
    Route::resource('items-collection', 'ItemsCollectionController');
    Route::get('collection/deleteRow/{id}', 'ItemsCollectionController@deleteRow');

    Route::resource('assembly', 'AssemblyController');
    Route::get('get-item-assembly/{id}', 'AssemblyController@getItemCollection');
    Route::get('assembly/deleteRow/{id}', 'AssemblyController@deleteRow');





    Route::get('get-item-collection/{id}', 'ItemsCollectionController@getItemCollection');
    Route::get('/categories-of-items', 'ItemsController@categories')->name('item.index.categories');



    Route::resource('ItemsSallesSaved', 'ItemsSallesSavedController');

    // accounts
    Route::get('accounts', 'AccountsController@index')->name('accounts.index');
    Route::get('accounts/create', 'AccountsController@create')->name('accounts.create');
    Route::post('accounts/store', 'AccountsController@store')->name('accounts.store');
    Route::get('accounts/show/{id}', 'AccountsController@show')->name('accounts.show');
    Route::get('accounts/edit/{id}', 'AccountsController@edit')->name('accounts.edit');
    Route::post('accounts/update/{id}', 'AccountsController@update')->name('accounts.update');
    Route::get('accounts/getaccounts/{id}', 'AccountsController@getAccounts')->name('accounts.getaccounts');
    Route::get('accounts/getaccounts/2/{id}/{parent}', 'AccountsController@getAccounts2')->name('accounts.getaccounts2');
    Route::get('accounts/getaccounts/3/{id}/{parent}/{child}', 'AccountsController@getAccounts3')->name('accounts.getaccounts3');
    Route::get('accounts/balance_sheet_group', 'AccountsController@balanceSheetGroup')->name('accounts.balanceSheetGroup');
    Route::get('accounts/balance_sheet_group/create', 'AccountsController@CreatebalanceSheet')->name('accounts.balanceSheetGroup.create');
    Route::post('accounts/balance_sheet_group/store', 'AccountsController@StorebalanceSheet')->name('accounts.balanceSheetGroup.store');

    Route::get('accounts-reports', 'AccountsController@AccountReports')->name('accounts.reports');



    // PurchasesItemsController
    Route::get('PurchasesItems', 'PurchasesItemsController@index')->name('PurchasesItemsController.index');
    Route::post('PurchasesItems/FilterItemsReports', 'PurchasesItemsController@FilterItemsReports')->name('PurchasesItemsController.FilterItemsReports');
    Route::get('PurchasesItems/ReportPurchase', 'PurchasesItemsController@ReportPurchase')->name('PurchasesItems.ReportPurchase');
    Route::post('PurchasesItems/filter-purchases', 'PurchasesItemsController@FilterItems');
    Route::post('PurchasesItems/generatePdfItems', 'PurchasesItemsController@generatePDFItems')->name('PurchasesItems.generatePdfItems');
    Route::get('Purchase/deleteRow/{id}', 'PurchasesController@deleteRow');

    Route::resource('purchase-order', 'PurchaseOrderController');
    Route::get('purchase-order/deleteRow/{id}', 'PurchaseOrderController@deleteRow');


    // OpeningBalanceController
    Route::get('opening_balance', 'OpeningBalanceController@index')->name('opening_balance.index');
    Route::get('opening_balance/create', 'OpeningBalanceController@create')->name('opening_balance.create');
    Route::post('opening_balance/store', 'OpeningBalanceController@store')->name('opening_balance.store');
    Route::delete('opening_balance/delete/{id}', 'OpeningBalanceController@destroy')->name('opening_balance.destroy');

    // OpeningBalanceAccountsController
    Route::get('opening_balance_accounts', 'OpeningBalanceAccountsController@index')->name('opening_balance_accounts.index');
    Route::get('opening_balance_accounts/create', 'OpeningBalanceAccountsController@create')->name('opening_balance_accounts.create');
    Route::post('opening_balance_accounts/store', 'OpeningBalanceAccountsController@store')->name('opening_balance_accounts.store');
    Route::get('opening_balance_accounts/edit/{id}', 'OpeningBalanceAccountsController@edit')->name('opening_balance_accounts.edit');
    Route::post('opening_balance_accounts/update/{id}', 'OpeningBalanceAccountsController@update')->name('opening_balance_accounts.update');
    Route::delete('opening_balance_accounts/delete/{id}', 'OpeningBalanceAccountsController@destroy')->name('opening_balance_accounts.destroy');
    Route::get('opening_balance_accounts/deleteRow/{id}', 'OpeningBalanceAccountsController@destroyRow');



    // Class Controller
    Route::get('item_movement', 'ClassController@index')->name('item_movement.index');
    Route::post('/item-movement/filter', 'ClassController@itemFilter');

  // Class Controller
  Route::get('items-balances', 'ItemsBalances@index')->name('items-balances.index');
  Route::post('/items-balances/filter', 'ItemsBalances@itemFilter');



    // Stock Valuation
    Route::get('stock-valuation', 'StockValuation@index')->name('stock-valuation.index');
    Route::get('getItemsByCatId/{catId}', 'StockValuation@getItemsByCategory')->name('stock-valuation.getItemsByCategory');
  Route::post('getDataStock/filter', 'StockValuation@StockFilter');



  // Budget Controller
    Route::get('budget', 'BudgetController@index')->name('budget.index');
    Route::post('/budget/filter', 'BudgetController@bagetFilter');

    // Bond
    Route::get('bonds/cash_receipt_voucher', 'BondController@index')->name('bond.cash_receipt_voucher'); // سند قبض نقدي
    Route::get('bonds/bank_receipt_voucher', 'BondController@index2')->name('bond.bank_receipt_voucher'); // سند قبض بنكي
    Route::get('bonds/voucher_for_cash', 'BondController@index3')->name('bond.voucher_for_cash'); // سند صرف نقدي
    Route::get('bonds/voucher_for_bank', 'BondController@index4')->name('bond.voucher_for_bank'); // سند صرف بنكي
    Route::get('bond/create/{type}', 'BondController@create')->name('bond.create');
    Route::post('bond/store/{type}', 'BondController@store')->name('bond.store');
    Route::get('bond/edit/{id}/{type}', 'BondController@edit')->name('bond.edit');
    Route::get('bond/print/{id}/{type}', 'BondController@print')->name('bond.print');

    Route::post('accounts/update/{id}/{type}', 'BondController@update')->name('bond.update');
    Route::delete('accounts/delete/{id}/{type}', 'BondController@delete')->name('bond.delete');

    // DailyRestrictions
    Route::get('daily_restrictions', 'DailyRestrictionsController@index')->name('daily.index');
    Route::get('daily_restrictions/create', 'DailyRestrictionsController@create')->name('daily.create');
    Route::post('daily_restrictions/store', 'DailyRestrictionsController@store')->name('daily.store');
    Route::delete('daily_restrictions/destroy/{id}', 'DailyRestrictionsController@destroy')->name('daily.destroy');
    Route::get('daily_restrictions/edit/{id}', 'DailyRestrictionsController@edit')->name('daily.edit');
    Route::post('daily_restrictions/update/{id}', 'DailyRestrictionsController@update')->name('daily.update');
    Route::get('daily_restrictions/print/{id}', 'DailyRestrictionsController@print')->name('daily.print');
    Route::get('daily_restrictions/deleteRow/{id}', 'DailyRestrictionsController@deleteRow');


    // AccountStatement
    Route::get('account-statement', 'AccountStatementController@index')->name('account.statement');
    Route::post('account-statement/getData', 'AccountStatementController@getData');
    Route::get('/account-statement-print', 'AccountStatementController@print');
    // costcenters reports
    Route::get('cost_centers_reports', 'CostCentersReports@index')->name('cost_centers_reports');
    Route::post('/cost_centers_reports/filter', 'CostCentersReports@Filter');

    // costcenters reports
    Route::get('income_list', 'IncomeListController@index')->name('income_list');
    Route::post('/income_list/filter', 'IncomeListController@Filter');

    // costcenters reports
    Route::get('financialCenter', 'FinancialCenterController@index')->name('FinancialCenter.index');
    Route::post('/financialCenter/filter', 'FinancialCenterController@Filter');


    // ReturnedInvoiceController
    Route::get('returnedInvoices', 'ReturnedInvoiceController@index')->name('returnedInvoices.index');
    Route::get('returnedInvoices/create', 'ReturnedInvoiceController@create')->name('returnedInvoices.create');
    Route::post('returnedInvoices/store', 'ReturnedInvoiceController@store')->name('returnedInvoices.store');
    Route::get('returnedInvoices/edit/{id}', 'ReturnedInvoiceController@edit')->name('returnedInvoices.edit');
    Route::post('returnedInvoices/update/{id}', 'ReturnedInvoiceController@update')->name('returnedInvoices.update');
    Route::delete('returnedInvoices/delete/{id}', 'ReturnedInvoiceController@destroy')->name('returnedInvoices.delete');

    // ReturnedInvoiceSallesController
    Route::get('SallesReturned', 'ReturnedInvoiceSallesController@index')->name('SallesReturned.returned');
    Route::get('SallesReturned/create', 'ReturnedInvoiceSallesController@create')->name('SallesReturned.create');
    Route::post('SallesReturned/store', 'ReturnedInvoiceSallesController@store')->name('SallesReturned.store');
    Route::get('SallesReturned/edit/{id}', 'ReturnedInvoiceSallesController@edit')->name('SallesReturned.edit');
    Route::post('SallesReturned/update/{id}', 'ReturnedInvoiceSallesController@update')->name('SallesReturned.update');
    Route::delete('SallesReturned/delete/{id}', 'ReturnedInvoiceSallesController@destroy')->name('SallesReturned.delete');

    // PermissionAddController
    Route::get('permission_add', 'PermissionAddController@index')->name('permission_add.index');
    Route::get('permission_add/create', 'PermissionAddController@create')->name('permission_add.create');
    Route::post('permission_add/store', 'PermissionAddController@store')->name('permission_add.store');
    Route::get('permission_add/edit/{id}', 'PermissionAddController@edit')->name('permission_add.edit');
    Route::post('permission_add/update/{id}', 'PermissionAddController@update')->name('permission_add.update');
    Route::delete('permission_add/delete/{id}', 'PermissionAddController@destroy')->name('permission_add.delete');

    // PermissionCashingController
    Route::get('permission_cashing', 'PermissionCashingController@index')->name('permission_cashing.index');
    Route::get('permission_cashing/create', 'PermissionCashingController@create')->name('permission_cashing.create');
    Route::post('permission_cashing/store', 'PermissionCashingController@store')->name('permission_cashing.store');
    Route::get('permission_cashing/edit/{id}', 'PermissionCashingController@edit')->name('permission_cashing.edit');
    Route::post('permission_cashing/update/{id}', 'PermissionCashingController@update')->name('permission_cashing.update');
    Route::delete('permission_cashing/delete/{id}', 'PermissionCashingController@destroy')->name('permission_cashing.delete');

    // Route::get('/getTimeZone', function(){
    //     Config::set('app.timezone',  'Africa/Cairo');
    //     return config('app.timezone');
    // });


    Route::get('/activation_tester', 'TermsReferenceController@index')->name('activate_test');

    // PointOfSale
    Route::get('PointOfSale', 'PointOfSaleController@index')->name('PointOfSale.index');

    // for test
    Route::post('/getDownloadPdf', 'PurchasesItemsController@createPdf')->name('createPdf');

    Route::post('/filter-items-reports', 'HomeController@FilterItemsReports');
    Route::get('generate-pdf/{id}', 'HomeController@generatePDF')->name('generate-pdf');
    Route::post('generate-pdf-items', 'ItemsSallesSavedController@generatePDFItems')->name('generatePDFItems.salles');

    Auth::routes();
    Route::get('/home', 'HomeController@index');
    Route::get('/back-up', 'HomeController@BackUp')->middleware('auth')->name('back-up');
    Route::get('/income', 'HomeController@incomeChart')->name('product.order.income');

    Route::post('upload-file', 'HomeController@upload')->name('upload.file');
    Route::get('/zip', 'HomeController@zipCreater');
    Route::get('/setting', 'HomeController@setting')->name('setting')->middleware('active_permision');
    Route::get('/extract', 'HomeController@extractFiles')->name('extractFiles');
    Route::post('/filter-date', 'HomeController@FilterDate');
    Route::post('/filter-items', 'HomeController@FilterItems');

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('printer-setting', 'HomeController@printerSetting')->middleware('auth')->name('printer.setting');
    Route::post('printer-setting/store', 'SettingPrinter@store')->middleware('auth')->name('printer.setting.store');

    Route::get('ReportsPrint', 'HomeController@ReportsPrint')->middleware('auth')->name('ReportsPrint');

    // reports
    Route::get('/reports', 'ReportsController@index')->name('reports.index');
    Route::post('/printItmesReport', 'ReportsController@ItemsReports');
    Route::get('/show/{id}', 'ReportsController@show')->name('reports.show');


    // user route
    Route::resource('users', 'UsersController');
    Route::get('users/permision/{id}', 'UsersController@permision')->name('users.permision');
    Route::post('users/permision/edit/{id}', 'UsersController@updateSide')->name('users.updates.side');
    Route::resource('employees', 'EmployeesController');
    Route::resource('currencies', 'CurrenciesController');
    Route::resource('fiscal_years', 'FiscalYearsController');
    Route::resource('cost_centers', 'CostCentersController');
    Route::get('cost_centers/getGroups/{id}', 'CostCentersController@getGroups');
    Route::get('cost_centers/getGroups2/{id1}/{id2}', 'CostCentersController@getGroups2');
    Route::get('cost_centers/getGroups3/{id1}/{id2}/{id3}', 'CostCentersController@getGroups3');

    Route::resource('compaines', 'CompainesController');
    Route::resource('branches', 'BranchesController');
    Route::resource('customers', 'CustomersController');
    Route::post('customers/pos', 'CustomersController@createCustomer');
    Route::resource('crm-customers', 'CRMCustomersController');
    Route::resource('supplier', 'SupplierControler');
    // sales
    Route::resource('salesBill', 'SalesBill');
    Route::resource('sell-order', 'SellOrderController');
    Route::resource('offer-price', 'OfferPriceController');
    Route::get('sell-order/deleteRow/{id}', 'SellOrderController@deleteRow');
    Route::get('offer-price/deleteRow/{id}', 'OfferPriceController@deleteRow');

    Route::get('getCustomer/{id}', 'SalesBill@getCustomer');
    Route::get('getProduct/{id}/{unit}', 'SalesBill@getProduct');
    // ////////////////////
    Route::get('offer-price/print/{id}', 'OfferPriceController@print')->name('offer-price.print');
    Route::get('salesBill/print/{id}', 'SalesBill@print')->name('sales.print');
    Route::get('sale-reports', 'SalesBill@Reports')->name('SaleReports.index');
    Route::get('sale/combined-billing-profits', 'SalesBill@BillingProfits')->name('combined-billing-profits');
    Route::post('sale/filter-billing', 'SalesBill@FilterBilling');

    // casher
    Route::resource('casher', 'CasherController');
    Route::post('casher/save', 'CasherController@save');
    Route::get('print-invoice', 'CasherController@printInvoice');


    Route::get('pos', 'POSController@index')->middleware('auth')->name('pos');
    Route::get('/GetHoldInvoice', 'POSController@GetHoldInvoice')->name('GetHoldInvoice');
    Route::get('/getInvoice/{id}', 'POSController@getInvoice')->name('getInvoice');
    Route::get('/activeHoldInvoice/{id}', 'POSController@ActiveHoldInvoice')->name('ActiveHoldInvoice');

    Route::get('open-shift', 'POSController@openShift')->middleware('auth');
    Route::get('close-shift', 'POSController@closeShift')->middleware('auth');
    Route::get('close-shift/printer', 'POSController@closeShiftPrinter')->middleware('auth');
    Route::post('pos/end-shift', 'POSController@endShift')->middleware('auth');
    Route::get('printers', 'POSController@printers')->middleware('auth')->name('printers');
    Route::post('pos/save/paynow', 'POSController@SavePayNow')->middleware('auth')->name('paynow');
    Route::post('pos/hold/paynow', 'POSController@SaveHold')->middleware('auth')->name('hold');
    Route::post('getItem/{id}', 'POSController@getItem')->name('getItem');
    Route::post('getItemById/{id}', 'POSController@getItemById')->name('getItem');
    Route::post('getItemDirect/{id}/{unitId}', 'POSController@ItemDirect')->name('ItemDirect');
    Route::post('getItemByBarCode/{barcode}', 'POSController@ItemByBarCode')->name('ByBarCode');

    // FileItems
    Route::get('file-items', 'ItemsController@FileItems')->name('file.items');
    Route::post('upload-items', 'ItemsController@FileItemsUpload')->name('upload.items');

    //
    Route::get('units', 'Units@index')->name('units');
    Route::get('add-unit', 'Units@add')->name('units-add');
    Route::post('add-unit', 'Units@store')->name('units.store');
    Route::get('unit/edit/{id}', 'Units@edit')->name('units.edit');
    Route::post('unit/update/{id}', 'Units@update')->name('units.update');
    Route::delete('unit-delete/{id}', 'Units@destroy')->name('unit.destroy');

    // Route::get('items', 'ItemsController@index')->name('item.index');

    Route::get('category', 'ItemsController@category')->name('item.index.category');
    Route::delete('/category/delete/{id}', 'ItemsController@deleteCat')->name('cat.delete');
    Route::get('/category/edit/{id}', 'ItemsController@editCategory')->name('cat.edit');
    Route::post('/category/update/{id}', 'ItemsController@updateCategory')->name('cat.update');
    Route::post('/add/category', 'ItemsController@AddCategory')->name('item.index.category.add');
    // Route::get('items/addItem', 'ItemsController@add')->name('item.add');
    // Route::post('items/store', 'ItemsController@store')->name('item.store');
    // Route::post('itemlist/delete', 'ItemsController@deleteItemList')->name('itemItem.delete');

    // Route::delete('items/delete/{id}', 'ItemsController@delete')->name('item.delete'); //

    // Route::get('items/edit/{id}', 'ItemsController@edit')->name('item.edit');
    // Route::post('items/update/{id}', 'ItemsController@update')->name('item.update');

    // Banner
    Route::resource('tables', 'TablesController');
    Route::resource('stores', 'StoresController');



    Route::get('/clearCash', "HomeController@ClearCash")->name('clearCash');
    Route::get('sales/deleteRow/{id}', 'SalesBill@deleteRow');



    // Route::get('/users_permisions','ApiController@UsersPermisions')->name('users.permisions');


    Route::get('/check-user', "ConfirmController@CheckUser")->middleware('cors');
    Route::get('/confirm-user/{secret_code}', "ConfirmController@confirmUser")->middleware('cors');

    Route::get('/check-user', "ConfirmController@CheckUser")->middleware('cors');
    Route::get('/confirm-user/{secret_code}', "ConfirmController@confirmUser")->middleware('cors')->name('confirmUser');
    Route::get('/run-user', "ConfirmController@runUser");
    Route::get('/check-version/{version}', "ConfirmController@checkVersion");
    Route::post('/downloadFile', "ConfirmController@downloadFile")->name('download.downloadFiles');

    Route::get('/change-activator', "ConfirmController@ChangeActivator");
    Route::get('/change-activator-active', "ConfirmController@ChangeActivatorActive");

    Route::get('/changeRef/{refS}/{refU}', "ConfirmController@ChangeRef");



    Route::post('/uploadDb', "UpdateDbController@upload")->name('uploadDb');
    Route::get('/updateDb', "UpdateDbController@update")->name('updateDb');

    Route::get('/check-version-db/{version}', "UpdateDbController@checkVersion");
    Route::post('/downloadDb', "UpdateDbController@downloadDb")->name('download.db');



    Route::get('/getDelevery', "TablesController@getDelevery");
    Route::get('/getDelevery/{id}', "TablesController@getDeleveryById");







    Route::get('zdk', 'ZDKController@index');
});
