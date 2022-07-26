<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refrence extends Model
{
    protected $table = 'reference';

    public $timestamps = false;

    protected $fillable = ['id', 'system', 'system_id', 'stores', 'stores_id', 'sales', 'sales_id', 'purchases', 'purchases_id', 'financial_account', 'bonds', 'point_of_sales', 'setting', 'backup', 'pos', 'other'];
}
