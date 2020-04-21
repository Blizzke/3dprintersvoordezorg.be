<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomersUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->newModelQuery();
        $query->where('identifier', $credentials['identifier']);
        return $query->first();
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $user->identifier == $credentials['identifier'];
    }
}
