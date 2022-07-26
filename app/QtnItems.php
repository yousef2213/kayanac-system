<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QtnItems extends Model
{
    protected $table = 'quantity_of_items';

    public $timestamps = false;

    protected $fillable = ['id', 'unit_id', 'item_id', 'store_id', 'qtn'];
}
