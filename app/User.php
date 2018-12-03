<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','last_login','email_token','temp_pass','last_login_at','last_login_ip'
    ];

    protected $hidden = [
        'remember_token','password'
    ];

    public function authorization()
    {
        return $this->hasOne('App\Authorization');
    }
}
