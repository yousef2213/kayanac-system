<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningBalanceAccountsList extends Model
{
    protected $table = 'opening_balance_accounts_list';

    public $timestamps = false;

    protected $fillable = [
        'id', 'account_name', 'account_id', 'invoice_id', 'debtor', 'creditor', 'description',
    ];
}
