<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $casts = [
        // Online variant doesn't auto return as correct variable type
        'status_id' => 'integer',
        'quantity' => 'integer',
        'is_internal' => 'boolean'
    ];

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

    public function getByAttribute()
    {
        if ($this->helper) {
            return $this->helper->name;
        }
        if ($this->customer) {
            return $this->customer->name;
        }

        return null;
    }

    public function setQuantityAttribute($quantity)
    {
        $this->attributes['quantity'] = (int) $quantity;
        $this->type = 'quantity';
    }

    public function setCommentAttribute($comment)
    {
        $this->attributes['comment'] = $comment;
        $this->type = 'comment';
    }

    public function setStatusIdAttribute($value)
    {
        $this->attributes['status_id'] = (int)$value;
        $this->type = 'status';
    }
}
