<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
    protected $table = 'suppliers';

    public $timestamps = false;

    protected $fillable = [
        'id', 'code', 'name','group','phone','VATRegistration','IdentificationNumber', 'address','account_id'
    ];
}
