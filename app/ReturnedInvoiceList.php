<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoiceList extends Model
{
    protected $table = 'returned_invoices_purchases_list';

    public $timestamps = false;

    protected $fillable = [
        'id', 'purchasesId', 'storeId', 'itemId', 'unitId', 'qtn', 'price', 'discountRate', 'discountValue', 'total', 'value', 'rate', 'nettotal', 'fiscal_year'
    ];
}
