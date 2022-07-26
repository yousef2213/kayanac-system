<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $table = 'currencies';

    public $timestamps = false;
    protected $fillable = [
        'id', 'bigar', 'bigen', 'smallar', 'smallen', 'main', 'rate', 'tax_code'
    ];
}
