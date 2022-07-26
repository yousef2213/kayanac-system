<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionCashing extends Model
{
    protected $table = 'permission_cashing';

    public $timestamps = true;

    protected $fillable = [
        'id', 'num', 'dateInvoice', 'customerId', 'payment', 'branchId', 'netTotal', 'source_num', 'source', 'storeId', 'fiscal_year'
    ];
}
