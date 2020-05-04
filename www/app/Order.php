<?php

namespace App;

use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    public const STATUSES = [0 => 'Nieuw', 1 => 'Toegewezen', 2 => 'In productie', 3 => 'Te leveren', 4 => 'Afgewerkt', 5 => 'Geannuleerd', 6 => 'Te valideren'];
    public const MATERIALS = ['pla' => 'PLA', 'petg' => 'PETG', 'doesntmatter' => 'Maakt niet uit'];

    protected $fillable = ['customer_id', 'for'];
    protected $casts = [
        // Online variant doesn't auto return as correct variable type
        'status_id' => 'integer',
        'quantity' => 'integer',
        'options' => 'array',
    ];

    protected $with = ['item', 'customer', 'helper', 'statuses'];

    public static function id_to_status($status)
    {
        return self::STATUSES[$status];
    }

    public static function status_to_id($status)
    {
        return array_flip(self::STATUSES)[$status];
    }

    public function getHelpIsWelcomeAttribute()
    {
        return $this->options['help_wanted'] ?? false;
    }

    public function setHelpIsWelcomeAttribute($state)
    {
        $this->setOption('help_wanted', (bool) $state);
    }

    public function getMaterialAttribute()
    {
        if (!isset($this->options['material']))
            return 'doesntmatter';

        return $this->options['material'];
    }

    public function getMaterialNameAttribute()
    {
        return self::MATERIALS[$this->material];
    }

    public function setMaterialAttribute($material)
    {
        if (!array_key_exists($material, self::MATERIALS))
            return;

        $this->setOption('material', $material);
    }

    private function setOption($name, $value)
    {
        $options = $this->options ?? [];
        $options[$name] = $value;
        $this->options = $options;
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (!empty($order->identifier)) {
                return;
            }

            do {
                # Unique identifier per customer so they can "login" later to add another request
                $identifier = random_int(1000000000, 2147483647);
            } while (self::whereIdentifier($identifier)->exists());

            $order->identifier = $identifier;
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

    public function getPrettyTimeAttribute()
    {
        return pretty_time($this->created_at);
    }

    public function getCanCancelAttribute()
    {
        /** @var Helper $user */
        $user = Auth::user();
        return $user->hasFeature('auth:dispatcher') && $this->status_id < 3;
    }

    public function getIsNewAttribute()
    {
        return $this->status_id === 0;
    }

    /**
     * true if the order can still be released back into the pool
     * @return bool
     */
    public function getCanReleaseAttribute()
    {
        return $this->is_mine && !$this->is_finished;
    }

    /**
     * Returns if the logged in person is the executor/coordinator of the order
     * @return bool
     */
    public function getIsMineAttribute()
    {
        return $this->helper_id == Auth::user()->id;
    }

    /**
     * Returns whether the person is working on the order (gives access to add comments and add quantity)
     * @return bool
     */
    public function getWorkingOnItAttribute()
    {
        /** @var Helper $searchedHelper */
        $searchedHelper = Auth::user();
        if (!$this->helper)
            return false;

        if ($this->helper->id === $searchedHelper->id)
            return true;

        foreach ($this->helpers as $helper)
            if ($helper->helper_id == $searchedHelper->id)
                return true;
        return false;
    }

    public function getIsInProductionAttribute()
    {
        return $this->status_id === 2;
    }

    public function getIsFinishedAttribute()
    {
        return $this->status_id >= 4 && $this->status_id !== 6;
    }

    public function getToValidateAttribute()
    {
        return $this->status_id === 6;
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id')->orderBy('order_statuses.id');
    }

    public function helpers()
    {
        return $this->hasMany(OrderHelper::class, 'order_id')->orderBy('order_helpers.approved');
    }

    public function getQuantityDoneAttribute()
    {
        $total = 0;
        foreach ($this->statuses->where('type', 'quantity') as $status) {
            $total += $status->quantity;
        }
        return $total;
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

    public function scopeNew(Builder $query)
    {
        return $query->where('status_id', 0);
    }

    public function scopeInProgress(Builder $query)
    {
        return $query->whereIn('status_id', [1, 2, 3])->orderBy('status_id')->orderBy('updated_at');
    }

    public function scopeYours(Builder $query)
    {
        // You orders are those you pledged help on
        $myId = Auth::user()->id;
        $helperOn = OrderHelper::select('order_id')->whereHelperId($myId)->get();
        // and the ones you coordinate for
        return $query->where('helper_id', $myId)->orWhereIn('id', $helperOn->pluck('order_id'))->orderBy('status_id');
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

    public function getIsRegisteredHelperAttribute()
    {
        $myId = Auth::user()->id;
        foreach ($this->helpers as $helper)
            if ($myId == $helper->helper_id)
                return true;
        return false;
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
     * @param bool|Helper|null $helper If filled, associate helper with the status. true to use the order $helper
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

    public function helperComment(string $comment, bool $is_internal = true)
    {
        $status = $this->newStatus(false, Auth::user());
        $status->is_internal = $is_internal;
        $status->comment = $comment;
        return $status->save();
    }

    public function release(Helper $helper = null)
    {
        $this->helper_id = null;
        $this->save();
        return $this->statusUpdateStatus(0, false, $helper);
    }

    public function cancel(Helper $helper = null)
    {
        $this->status_id = 5;
        $this->save();
        return $this->statusUpdateStatus($this->status_id, false, $helper);
    }

    public function closestHelpers($limit = 5): ?array
    {
        if (!$this->customer)
            return [];

        $list = collect(Helper::getGeoList($this->customer));
        if ($this->is_new) {
            $helpers = Helper::makesItem($this->item)->map->only('id')->pluck('id');
        }
        else {
            // Not new order, select coordinator and possible helpers
            $helpers = array_merge([$this->helper->id], $this->helpers()->select('helper_id')->pluck('helper_id')->toArray());
        }
        $list = $list->whereIn('id', $helpers);
        if ($limit !== false)
            $list = $list->take($limit);

        return $list->toArray();
    }
}
