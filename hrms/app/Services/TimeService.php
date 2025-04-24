<?php

namespace App\Services;

use Carbon\Carbon;

class TimeService
{
    public static function now()
    {
        $custom = session('custom_time');
        return $custom ? Carbon::parse($custom) : Carbon::now();
    }

    public static function setTime($time)
    {
        session(['custom_time' => $time]);
    }

    public static function resetTime()
    {
        session()->forget('custom_time');
    }
}