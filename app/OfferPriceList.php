<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferPriceList extends Model
{
    protected $table = 'offer_price_list';

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
