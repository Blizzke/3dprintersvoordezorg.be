<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHelper extends Model
{
    protected $fillable = ['quantity', 'comment'];
    protected $casts = [
        // Online variant doesn't auto return as correct variable type
        'order_id' => 'integer',
        'helper_id' => 'integer',
        'quantity' => 'integer',
        'approved' => 'bool',
    ];

    protected $with = ['order', 'helper'];

    public function getDisplayNameAttribute()
    {
        return $this->helper->display_name;
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getContributedAttribute()
    {
        return OrderStatus::contributed($this->order, $this->helper);
    }

}
