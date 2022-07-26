<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BondList extends Model
{
    protected $table = 'bond_list';

    public $timestamps = false;

    protected $fillable = ['id', 'cost_center', 'delegate', 'currency', 'cost_center_name', 'bond_id', 'amount', 'balance', 'description', 'account_id', 'account_name'];
}
