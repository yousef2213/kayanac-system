<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = 'accounts';

    public $timestamps = true;

    protected $fillable = ['id', 'namear', 'nameen', 'parent', 'child', 'parentId', 'balance_sheet', 'parent_2_id', 'parent_3_id', 'parent_4_id', 'parent_5_id'];
}
