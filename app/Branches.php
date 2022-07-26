<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $table = 'branches';

    public $timestamps = true;

    protected $fillable = [
        'id', 'namear', 'nameen', 'city', 'region', 'country', 'phone', 'updated_at', 'created_at', 'companyId', 'address', 'code_activite', 'activite_code'
    ];
}
