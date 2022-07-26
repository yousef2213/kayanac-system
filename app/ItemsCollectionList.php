<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsCollectionList extends Model
{
    protected $table = 'items_collection_list';

    public $timestamps = false;

    protected $fillable = ['id', 'collection_id', 'itemId', 'unitId', 'qtn'];
}
