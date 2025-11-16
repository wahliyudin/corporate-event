<?php

use App\Helper\AuthHelper;
use Illuminate\Support\Carbon;

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

if (!function_exists('carbon_YmdHi')) {
    function carbon_YmdHi($date)
    {
        if (empty($date)) {
            return '';
        }
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }
        return $date->format('Y-m-d H:i') . ' WIB';
    }
}
