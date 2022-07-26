<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';

    public $timestamps = true;
    protected $fillable = [
        'id', 'namear', 'nameen', 'status', 'status_type', 'branchId', 'occupation', 'account_id'
    ];
}
