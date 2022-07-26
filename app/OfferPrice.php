<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferPrice extends Model
{
    protected $table = 'offer_price';

    public $timestamps = true;

    protected $fillable = [
        'id', 'netTotal', 'fiscal_year', 'date_follow', 'discount_added', 'branchId', 'cash', 'visa', 'masterCard', 'credit', 'shiftNum', 'customerId', 'status', 'storeId', 'cost_center', 'taxSource'
    ];
}
