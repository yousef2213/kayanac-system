<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table = 'invoices';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'netTotal',
        'fiscal_year',
        'dateInvoice',
        'duedate' ,
        'branchId',
        'cash',
        'visa',
        'tab',
        'masterCard',
        'credit',
        'shiftNum',
        'customerId',
        'delegateId',
        'status_type',
        'status',
        'deleiver',
        'storeId',
        'cost_center',
        'taxSource',
        'tobacco_tax'
    ];
}
