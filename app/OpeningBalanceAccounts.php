<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningBalanceAccounts extends Model
{
    protected $table = 'opening_balance_accounts';

    public $timestamps = false;

    protected $fillable = [
        'id', 'branchId', 'date', 'debtor', 'creditor', 'source'
    ];
}
