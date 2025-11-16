<?php

namespace App\Helper;

use App\Models\User;

class AuthHelper
{
    public static function user($guard = null): ?User
    {
        return auth()->guard($guard)->user();
    }
}
