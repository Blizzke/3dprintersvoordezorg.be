<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;

class Helper extends Model implements AuthenticatableContract
{
    public const COUNTRIES = [1 => 'België', 2 => 'Nederland'];
    use Notifiable, Authenticatable, GeoLocationMixin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'street', 'number', 'zip', 'city', 'country_id', 'email', 'phone', 'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'geolocation' => 'array',
    ];

    public function getTitleAttribute()
    {
        return $this->display_name;
    }

    public function getCountryAttribute($value)
    {
        return self::COUNTRIES[$value];
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country_id'] = self::COUNTRIES[$value];
    }

    public function fetchUserByCredentials(array $credentials)
    {
        $arr_user = $this->conn->find('users', ['username' => $credentials['username']]);

        if (!is_null($arr_user)) {
            $this->username = $arr_user['username'];
            $this->password = $arr_user['password'];
        }

        return $this;
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'helper_features');
    }

    public function hasFeature($featureName)
    {
        if (is_numeric($featureName)) {
            $featureName = Feature::find($featureName)->identifier;
        }
        foreach ($this->features as $feature)
            if ($feature->matches($featureName))
                return true;
        return false;
    }

    public function registerFeature($featureName)
    {
        if ($this->hasFeature($featureName))
            return;

        $feature = Feature::findByIdentifier($featureName);
        $this->features()->attach($feature->id);
    }

    public function removeFeature($featureName)
    {
        $feature = Feature::findByIdentifier($featureName);
        $this->features()->detach($feature->id);
    }

    public static function makesItem(Item $item)
    {
        $feature = Feature::findByIdentifier('item', $item->type);
        return self::whereIn('id', function (Builder $query) use ($feature) {
            return $query->from('helper_features')->select('helper_id')->whereFeatureId($feature->id);
        })->get();
    }

    public function getAuthIdentifierName()
    {
        return 'name';
    }
}
