<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CRMCustomer extends Model
{
    protected $table = 'crm_customers';

    public $timestamps = false;

    protected $fillable = [
        'id', 'code', 'name', 'namear', 'nameen', 'group', 'phone', 'VATRegistration', 'IdentificationNumber', 'address', 'account_id', 'employee'
    ];
}
