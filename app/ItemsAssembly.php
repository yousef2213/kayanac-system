<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsAssembly extends Model
{
    protected $table = 'items_assembly';

    public $timestamps = false;

    protected $fillable = ['id', 'itemId', 'unitId', 'storeId', 'description', 'qtn', 'startDate', 'endDate', 'cost'];
}
