<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefUser extends Model
{
    protected $table = 'ref';

    public $timestamps = false;

    protected $fillable = ['id', 'ref'];
}
