<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FiscalYears extends Model
{
    protected $table = 'fiscal_years';

    public $timestamps = true;
    protected $fillable = [
        'id', 'code', 'start', 'end', 'status', 'notes'
    ];
}
