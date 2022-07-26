<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermsReference extends Model
{
    protected $table = 'terms_of_reference';

    public $timestamps = false;

    protected $fillable = ['secret_code', 'experimental', 'activation', 'date', 'movements'];
}
