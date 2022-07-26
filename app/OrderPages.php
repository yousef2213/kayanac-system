<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPages extends Model
{
    protected $table = 'orders_pages';

    public $timestamps = false;

    protected $fillable = ['id', 'user_id', 'power_id', 'power_name', 'show', 'add', 'edit', 'delete'];
}
