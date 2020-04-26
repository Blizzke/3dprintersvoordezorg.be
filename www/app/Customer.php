<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Customer extends Model implements AuthenticatableContract
{
    use GeoLocationMixin;

    public const COUNTRIES = [1 => 'België', 2 => 'Nederland'];
    use Authenticatable;
    protected $fillable = ['sector', 'name', 'phone', 'mobile', 'email', 'street', 'number', 'zip', 'city', 'country_id'];
    protected $casts = [
        'geolocation' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($customer) {
            if (!empty($customer->identifier)) {
                return;
            }

            do {
                # Unique identifier per customer so they can "login" later to add another request
                $identifier = random_int(1000000000, 2147483647);
            } while (self::whereIdentifier($identifier)->exists());

            $customer->identifier = $identifier;
        });
        parent::booted();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id')->orderByDesc('id');
    }

    public function getTitleAttribute()
    {
        return $this->name;
    }

    public function getCountryAttribute()
    {
        return self::COUNTRIES[$this->country_id];
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country_id'] = self::COUNTRIES[$value];
    }

    public function getLocationAttribute()
    {
        return implode(' ', [$this->zip, $this->city]);
    }

    public function getAuthIdentifierName()
    {
        return 'identifier';
    }
}

