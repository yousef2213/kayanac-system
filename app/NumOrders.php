<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumOrders extends Model {
    protected $table = 'numorders';

    public $timestamps = false;

    protected $fillable = [
        'id', 'num'
    ];
}
