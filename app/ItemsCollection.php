<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsCollection extends Model
{
    protected $table = 'items_collection';

    public $timestamps = false;

    protected $fillable = ['id', 'itemId', 'unitId', 'startDate', 'endDate'];
}
