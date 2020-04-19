<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class HelpersUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->newModelQuery();
        $query->where('name', $credentials['name']);
        $user = $query->first();
        if (!$user)
            return null;

        return in_array($credentials['phone'], [$user->phone, $user->mobile]) ? $user : null;
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return strtolower($user->name) === strtolower($credentials['name']) &&
            in_array($credentials['phone'], [$user->phone, $user->mobile]);
    }
}
