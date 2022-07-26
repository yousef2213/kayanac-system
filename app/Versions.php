<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Versions extends Model
{
    protected $table = 'versions';

    public $timestamps = false;

    protected $fillable = [
        "id", "active", "updateDate", 'version',
    ];
}
