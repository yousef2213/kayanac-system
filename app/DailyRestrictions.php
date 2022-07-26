<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyRestrictions extends Model
{
    protected $table = 'dailyrestrictions';

    public $timestamps = true;

    protected $fillable = [
        'id', 'date', 'num', 'branshId', 'description', 'document', 'creditor', 'debtor', 'source', 'source_name', 'fiscal_year', 'manual'
    ];
}
