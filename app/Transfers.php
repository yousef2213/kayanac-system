<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfers extends Model
{
    protected $table = 'transfers';

    public $timestamps = false;

    protected $fillable = ['id', 'branchId', 'storeId1', 'storeId2', 'description', 'date'];
}
