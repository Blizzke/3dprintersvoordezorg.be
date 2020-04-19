<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    public const STATUSES = [0 => 'nieuw', 1 => 'toegewezen', 2 => 'in productie', 3 => 'te leveren', 4 => 'afgewerkt,', 5 => 'geannuleerd'];

    public static function id_to_status($status)
    {
        return self::STATUSES[$status];
    }

    public static function status_to_id($status)
    {
        return array_flip(self::STATUSES)[$status];
    }

    protected static function booted()
    {
        self::creating(function ($order) {
            # Guess probability is low we'll have 2 orders on exactly the same second
            if (empty($order->identifier)) {
                $order->identifier = time();
            }
        });
        parent::booted();
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getIsMineAttribute()
    {
        return $this->helper_id == Auth::user()->id;
    }

    public function getIsFinishedAttribute()
    {
        return $this->status_id >= 4;
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    public function setStatusAttribute($value)
    {
        if (!is_int($value)) {
            $value = self::STATUSES[$value];
        }
        $this->attributes['status_id'] = $value;
    }

    public function getStatusAttribute(): string
    {
        return self::STATUSES[$this->status_id];
    }

    public function scopeNew($query)
    {
        return $query->where('status_id', 0);
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status_id', [1, 2, 3]);
    }

    public function scopeYours($query)
    {
        return $query->where('helper_id', Auth::user()->id);
    }
}
