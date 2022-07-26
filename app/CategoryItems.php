<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryItems extends Model
{

    protected $table = 'categoryitems';

    public $timestamps = false;

    protected $fillable = [
        'id', 'namear', 'nameen', 'img', 'main', 'main_id'
    ];
}
