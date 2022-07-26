<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $table = 'purchases';

    public $timestamps = true;

    protected $fillable = [
        'id', 'dateInvoice', 'supplier', 'payment', 'branchId', 'supplier_invoice', 'fiscal_year', 'taxSource', 'netTotal'
    ];
}
