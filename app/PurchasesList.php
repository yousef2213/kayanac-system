<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasesList extends Model
{
    protected $table = 'purchaseslist';

    public $timestamps = false;

    protected $fillable = ['id', 'purchasesId', 'storeId', 'qtn_unit', 'av_price', 'itemId', 'unitId', 'qtn', 'price', 'discountRate', 'discountValue', 'total', 'value', 'rate', 'nettotal'];
}
