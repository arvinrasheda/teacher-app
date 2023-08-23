<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public static function attempt($username, $password)
    {
        $user = self::where('username', $username)->where('pass', $password)->first();
        return $user;
    }
}
