<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellOrderList extends Model
{
protected $table = 'sell_order_list';

    public $timestamps = false;
    protected $fillable = [
        'id',
        'status',
        'invoiceId',
        'customer_id',
        'unit_id',
        'storeId',
        'item_id',
        'item_name',
        'qtn',
        'price',
        'discountRate',
        'discountValue',
        'rate',
        'value',
        'total',
        'nettotal',
        'description'
    ];
}
