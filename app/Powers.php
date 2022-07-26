<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Powers extends Model
{
    protected $table = 'powers';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'TsSystem',
        'TsStores',
        'TsSales',
        'TsPurchases',
        'TsAccounts',
        'TsPointOfSales',
        'TsSettings',
        'TsCompany',
        'TsBranchs',
        'TsFiscalYears',
        'TsCurrencies',
        'TsUsers',
        'TsEmployees',
        'TsCustomers',
        'TsSuppliers',
        //
        'TsCategoryCard',
        'TsItems',
        'TsUnits',
        'TsStoresOpeningBalance', // رصيد افتتاحي المخازن
        "TsGroupItems",// مجموعة الاصناف
        'TsDefinitionStores', // تعريف المخازن
        'TsOrderAdd', // اذن اضافة
        'TsOrderCashing', //  اذن صرف
        'TsCollectionOfItems', // التجميع
        'TsTransfersStores', // تحويلات المخازن
        'TsItemsBalances', // ارصدة الاصناف
        'TsStoreEvaluation', // تقييم المخزون
        // مبيعات
        'TsInvoiceSales',
        'TsInvoiceReports',
        'TsPriceOfferSalles', // عرض سعر - مبيعات
        "TsSellOrderSalles", // امر بيع - مبيعات
        'TsReturnedSales',
        'TsReportsItemsSals',
        // مشتريات
        'TsInvoicePurchases',
        'TsPurchasesReports',
        'TsReturnedPurchases',
        'TsReportsItemsPurchases',
        // دليل الحسابات
        'TsAccountsGuide', // دليل الحسابات
        'TsCostCenters', // مراكز التكلفة
        'TsRestrictions', // قيود اليومية
        'TsAccountStatement', //
        'TsOpeningAccounts', // رصيد افتتاحي
        'TsBudgetReport', //
        'TsCostCenterReport',  //
        // سندات
        'TsBonds',
        'TsCashReceipt', // سند قبض نقدي
        'TsCashExChange', // سند صرف نقدي
        'TsBankReceipt', // سند قبض بنكي
        'TsBankExChange', // سند صرف بنكي
        // نقاط البيع
        'TsPrintSetting',
        'TsTablesResturant',
        'TsShiftReport',
        //



    ];
}
