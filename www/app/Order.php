<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [0 => 'nieuw', 1 => 'geaccepteerd', 2 => 'in productie', 3 => 'afgewerkt', 4 => 'geleverd', 5 => 'geannuleerd'];

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

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    public function setStatus($value)
    {
        if (!is_int($value)) {
            $value = self::STATUSES[$value];
        }
        $this->attributes['status_id'] = $value;
    }

    public function getStatus(): string
    {
        return self::STATUSES[$this->status_id];
    }

    public static function id_to_status($status)
    {
        return self::STATUSES[$status];
    }

    public static function status_to_id($status)
    {
        return array_flip(self::STATUSES)[$status];
    }

    public function setFillable(array $fillable): void
    {
        $this->fillable = $fillable;
    }

    # Generic order placed
    # id
    # status: new / accepted / finished / canceled
    # timestamp
    # customer-id
    # accepting user (facilitator)
    # item-id (fk)
    # amount
    # comments
}
