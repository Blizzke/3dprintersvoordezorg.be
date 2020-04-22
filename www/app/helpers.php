<?php


use App\Customer;
use App\Helper;
use Illuminate\Support\Facades\Auth;

function is_helper()
{
    return Auth::user() instanceof Helper;
}

function is_customer()
{
    return Auth::user() instanceof Customer;
}

function pretty_time($time)
{
    if ($time instanceof DateTime) {
        $carbon = \Carbon\Carbon::instance($time);
    }
    else {
        $carbon = \Carbon\Carbon::parse($time, 'UTC');
    }
    return $carbon->format('d/m/Y H:i');
}
