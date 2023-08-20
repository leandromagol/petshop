<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class FirebaseJWTAuthProvider implements UserProvider
{
    public function retrieveByCredentials(array $credentials): \Illuminate\Database\Eloquent\Builder|User|Authenticatable|null
    {
        if (isset($credentials['user_uuid'])) {
            return User::where('uuid', $credentials['user_uuid'])->first();
        }
        return null;
    }

    public function retrieveById($identifier)
    {
    }

    public function retrieveByToken($identifier, $token)
    {
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return $user instanceof User;
    }
}
