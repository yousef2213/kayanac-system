<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoice extends Model
{
    protected $table = 'returned_invoices_purchases';

    public $timestamps = true;

    protected $fillable = [
        'id', 'dateInvoice', 'supplier', 'payment', 'branchId', 'supplier_invoice', 'fiscal_year'
    ];
}
