<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model {
    protected $table = 'shifts';
    public $timestamps = true;
    protected $fillable = [
        'id','opening','openDate','closeDate','closeing'
    ];
}
