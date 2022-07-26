<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransfersList extends Model
{
    protected $table = 'transfers_list';

    public $timestamps = false;

    protected $fillable = ['id', 'transferId', 'itemId', 'unitId', 'description', 'qtn', 'cost'];
}
