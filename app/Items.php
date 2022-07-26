<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';

    public $timestamps = false;

    protected $fillable = [
        'id', 'namear', 'nameen', 'active', 'taxRate', 'quantityM', 'item_type', 'nature', 'group', 'priceWithTax', 'description', 'img', 'catId', 'coding_type', 'code','delegateC'
    ];
}
