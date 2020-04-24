<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;


class Helper extends Model implements AuthenticatableContract
{
    public const COUNTRIES = [1 => 'België', 2 => 'Nederland'];
    use Notifiable, Authenticatable;

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

    public function getAuthIdentifierName()
    {
        return 'name';
    }
}
