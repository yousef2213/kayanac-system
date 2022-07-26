<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    protected $table = 'opening_balance';

    public $timestamps = false;

    protected $fillable = [
        'id', 'storeId', 'date'
    ];
}
