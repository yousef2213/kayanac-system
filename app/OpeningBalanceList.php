<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningBalanceList extends Model
{
    protected $table = 'opening_balance_list';

    public $timestamps = false;

    protected $fillable = ['id', 'invoice_id', 'itemId', 'unitId', 'qtn', 'price', 'discountRate', 'discountValue', 'total', 'value', 'rate', 'nettotal'];
}
