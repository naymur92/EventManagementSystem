<?php

namespace App\Core;

use App\Models\User;

class Auth
{
    /**
     * Get authenticated user
     *
     * @return User|null
     */
    public static function user(): User|null
    {
        $user = Session::get('user');
        return $user ? User::makeInstance((array) $user) : null;
    }
}
