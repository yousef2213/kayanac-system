<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    protected $table = 'bond';

    public $timestamps = true;

    protected $fillable = ['id', 'num', 'account_id', 'account_name', 'status', 'description', 'date', 'type', 'fiscal_year'];
}
