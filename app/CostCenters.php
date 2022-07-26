<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostCenters extends Model
{

    protected $table = 'cost_centers';

    public $timestamps = false;

    protected $fillable = [
        'id', 'num', 'namear', 'nameen', 'group1', 'group2', 'group3', 'group4', 'parent', 'child'
    ];
}
