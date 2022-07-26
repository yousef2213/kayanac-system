<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsAssemblyList extends Model
{
    protected $table = 'items_assembly_list';

    public $timestamps = false;

    protected $fillable = ['id', 'assembly_id', 'itemId', 'unitId', 'qtn'];
}
