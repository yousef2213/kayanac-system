<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compaines extends Model
{
    protected $table = 'compaines';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'companyNameAr',
        'companyNameEn',
        'logo',
        'active',
        'restaurant',
        'taxNum',
        'tax_source',
        'tobacco_tax',
        'printFront',
        'negative_sale',
        'signature_type',
        'token_serial_name',
        'token_pin_password',
        'document_type_version',
        'client_secret',
        'client_id',
        'country_tax_code',
        'type_invoice_electronic',
        'show_document_url',
        'document_url',
        'token_url'
    ];
}
