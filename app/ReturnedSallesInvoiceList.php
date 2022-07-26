<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedSallesInvoiceList extends Model
{
    protected $table = 'returned_salles_list';

    public $timestamps = false;

    protected $fillable = [
        'id', 'invoiceId', 'storeId', 'itemId', 'unitId', 'qtn', 'price', 'discountRate', 'discountValue', 'total', 'value', 'rate', 'nettotal',
    ];
}
