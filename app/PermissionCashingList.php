<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionCashingList extends Model
{
    protected $table = 'permission_cashing_list';

    public $timestamps = false;

    protected $fillable = ['id', 'invoiceId', 'source_num', 'storeId', 'itemId', 'unitId', 'qtn', 'price', 'discountRate', 'discountValue', 'total', 'value', 'rate', 'nettotal'];

}
