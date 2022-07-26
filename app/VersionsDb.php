<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VersionsDb extends Model
{
    protected $table = 'version_db';

    public $timestamps = false;

    protected $fillable = [
        "id", "active", "file", 'version', 'date', 'name'
    ];
}
