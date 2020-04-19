<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public const COUNTRIES = [1 => 'Belgi&euml;', 2 => 'Nederland'];

    protected static function booted()
    {
        static::creating(function ($customer) {
            if (!empty($customer->identifier)) {
                return;
            }

            do {
                # Unique identifier per customer so they can "login" later to add another request
                $identifier = random_int(1000000000, 9999999999);
            } while (self::whereIdentifier($identifier)->exists());

            $customer->identifier = $identifier;
        });
        parent::booted();
    }

    public function getCountry($value)
    {
        return self::COUNTRIES[$value];
    }

    public function setCountry($value)
    {
        $this->attributes['country_id'] = self::COUNTRIES[$value];
    }


}

