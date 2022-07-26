<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
     protected $table = 'sell_order';

    public $timestamps = true;

    protected $fillable = [
        'id', 'netTotal', 'fiscal_year', 'branchId', 'cash', 'visa', 'masterCard', 'credit', 'shiftNum', 'customerId', 'status', 'storeId', 'cost_center', 'taxSource'
    ];
}
