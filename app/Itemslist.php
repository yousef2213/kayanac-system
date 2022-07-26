<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemslist extends Model
{
    protected $table = 'itemslist';

    public $timestamps = false;

    protected $fillable = ['id', 'unitId', 'small_unit', 'itemId', 'packing', 'barcode', 'price1', 'price2', 'price3', 'price4', 'price5', 'discountRate', 'discountValue', 'total', 'av_price'];
}
