<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetGroup extends Model
{
    protected $table = 'balancesheetgroup';

    public $timestamps = false;

    protected $fillable = [
        'id', 'namear', 'nameen'
    ];
}
