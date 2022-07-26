<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreModel extends Model
{
    protected $table = 'stores';

    public $timestamps = false;

    protected $fillable = ['id', 'namear', 'nameen', 'branchId', 'active', 'main'];
}
