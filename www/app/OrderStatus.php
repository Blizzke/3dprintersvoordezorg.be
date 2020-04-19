<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    // order id
    // user id
    // quantity
    // status
    // comment
    // internal (yes no)

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class, 'helper_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
