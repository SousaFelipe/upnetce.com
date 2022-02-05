<?php
namespace App\Repositories;


use App\Models\User;


class UserRepo extends Respository
{
    public static function findByEmail(string $email)
    {
        return self::bind(User::class)
            ->where('email', $email)
            ->first();
    }
}
