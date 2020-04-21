<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    public const STATUSES = [0 => 'Nieuw', 1 => 'Toegewezen', 2 => 'In productie', 3 => 'Te leveren', 4 => 'Afgewerkt', 5 => 'Geannuleerd'];
    protected $casts = [
        // Online variant doesn't auto return as correct variable type
        'status_id' => 'integer',
        'quantity' => 'integer',
    ];

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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getCanCancelAttribute()
    {
        // Can cancel new orders or ones that are assigned to you and not finished
        return $this->status_id === 0 or
            ($this->is_mine && $this->status_id < 3);
    }

    public function getIsNewAttribute()
    {
        return $this->status_id === 0;
    }

    public function getCanReleaseAttribute()
    {
        return $this->is_mine && !$this->is_finished;
    }

    public function getIsMineAttribute()
    {
        return $this->helper_id == Auth::user()->id;
    }

    public function getIsInProductionAttribute()
    {
        return $this->status_id === 2;
    }

    public function getIsFinishedAttribute()
    {
        return $this->status_id >= 4;
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id')->orderBy('order_statuses.id');
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

    public function assign(Helper $helper)
    {
        $this->helper()->associate($helper);
        return $this->statusUpdateStatus(1, false, $helper);
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class);
    }

    public function statusUpdateStatus(int $newStatus, bool $customer = false, Helper $helper = null)
    {
        $this->status_id = $newStatus;
        $this->save();

        $status = $this->newStatus($customer, $helper);
        $status->status_id = $this->status_id;
        $status->save();
        return $status;
    }

    /**
     * Create a new order status
     * @param bool $customer If true, associated the customer with the status
     * @param bool|\App\Helper|null $helper If filled, associate helper with the status. true to use the order $helper
     * @return OrderStatus
     */
    public function newStatus($customer = false, $helper = null): OrderStatus
    {
        $order_status = new OrderStatus();
        $order_status->order()->associate($this);
        if ($customer) {
            $order_status->customer()->associate($this->customer);
        }
        if ($helper) {
            $order_status->helper()->associate(is_bool($helper) ? $this->helper : $helper);
        }
        return $order_status;
    }

    public function release(Helper $helper = null)
    {
        $this->helper_id = null;
        return $this->statusUpdateStatus(0, false, $helper);
    }

}
