<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedSallesInvoice extends Model
{
    protected $table = 'returned_salles';

    public $timestamps = true;

    protected $fillable = [
        'id', 'netTotal', 'fiscal_year', 'branchId', 'cash', 'visa', 'masterCard', 'credit', 'shiftNum', 'customerId', 'status', 'storeId', 'cost_center', 'taxSource'

    ];
}
