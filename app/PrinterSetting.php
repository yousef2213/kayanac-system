<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrinterSetting extends Model {
    protected $table = 'printersetting';

    public $timestamps = false;

    protected $fillable = [
        'id','printkitchen','printcasher','printReports','print_qr'
    ];
}
