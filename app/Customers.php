<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{

    protected $table = 'customers';

    public $timestamps = false;

    protected $fillable = [
        'id', 'code', 'name', 'namear', 'nameen', 'group', 'phone', 'VATRegistration', 'IdentificationNumber', 'address', 'account_id', 'type_invoice_electronice','delegateId', 'Obalance', 'TObalance', 'term_maturity', 'pricing_policy', 'is_credit_limit', 'credit_limit'
    ];
}
