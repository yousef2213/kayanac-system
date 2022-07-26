<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TablesModal extends Model {
    protected $table = 'tables';

    public $timestamps = true;

    protected $fillable = [
        'id','numTable'
    ];
}
