<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefrenceItems extends Model
{
    protected $table = 'reference_items';

    public $timestamps = false;

    protected $fillable = ['id', 'parent_id', 'name', 'active'];
}
