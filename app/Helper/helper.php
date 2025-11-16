<?php

use App\Helper\AuthHelper;

if (!function_exists('hasRole')) {
    function hasRole($role)
    {
        return AuthHelper::user()->hasRole($role);
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return AuthHelper::user()->hasPermission($permission);
    }
}
