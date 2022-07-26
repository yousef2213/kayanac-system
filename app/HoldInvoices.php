<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoldInvoices extends Model {
    protected $table = 'holdinvoices';

    public $timestamps = false;

    protected $fillable = [
        'id', 'namear', 'nameen','taxRate','quantityM','nature','groupItem','priceWithTax','description','img','price','catId','total','customerId','netTotal','invoiceId'
    ];
}
