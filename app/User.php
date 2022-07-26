<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'id','name', 'email', 'password','status','role','barnchId','password'
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
