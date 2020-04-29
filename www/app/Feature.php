<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $casts = ['modifiable' => 'bool'];
    public $timestamps = false;

    public function helpers()
    {
        return $this->belongsToMany(Helper::class, 'helper_features');
    }

    public function getIdentifierAttribute()
    {
        return $this->type . ':' . $this->value;
    }

    /**
     * Compares the feature identifier with the given values. Either 1 is given ("type:value") or both are
     * given (type, value)
     * @param string $val1  type:value or type
     * @param string|null $val2 optional value in case we want to use 2 parts
     * @return bool
     */
    public function matches(string $val1, string $val2 = null)
    {
        if (!$val2)
            return $this->identifier === $val1;

        return $val1 === $this->type && $val2 === $this->value;
    }

    public function scopeModifiable(Builder $query)
    {
        return $query->whereModifiable(1);
    }

    public function scopeNotModifiable(Builder $query)
    {
        return $query->whereModifiable(0);
    }

    public static function findByIdentifier(string $val1, string $val2 = null)
    {
        [$type, $value] = [$val1, $val2];
        if (!$value) {
            [$type, $value] = explode(':', $val1, 2);
        }

        return self::whereType($type)->whereValue($value)->firstOrFail();
    }
}
