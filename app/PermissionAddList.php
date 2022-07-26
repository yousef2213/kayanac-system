<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionAddList extends Model
{
    protected $table = 'permission_add_list';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'invoiceId',
        'source_num',
        'itemId',
        'unitId',
        'qtn',
        'price',
        'discountRate',
        'discountValue',
        'total',
        'value',
        'rate',
        'nettotal'
    ];
}
