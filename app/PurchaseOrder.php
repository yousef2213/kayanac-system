<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';

    public $timestamps = true;

    protected $fillable = [
        'id', 'dateInvoice', 'supplier', 'payment', 'branchId', 'supplier_invoice', 'fiscal_year', 'taxSource', 'netTotal','date_follow'
    ];
}
