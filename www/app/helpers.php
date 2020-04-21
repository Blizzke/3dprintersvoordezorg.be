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
