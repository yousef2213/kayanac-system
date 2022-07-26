<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyRestrictionsList extends Model
{
    protected $table = 'dailyrestrictions_list';

    public $timestamps = false;

    protected $fillable = [
        'id', 'account_name', 'account_id', 'invoice_id', 'debtor', 'creditor', 'cost_center', 'description', 'currency'
    ];
}
