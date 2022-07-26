<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';

    public $timestamps = false;

    protected $fillable = ['id', 'name', 'page_name', 'parent', 'parent_id', 'active'];
}
