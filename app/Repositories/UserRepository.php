<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function createRegisterUser($validatedUser) : User
    {
        return User::create($validatedUser); 
    }

    public function createUserAccessToken($user) : String
    {
        return $user->createToken('authToken')->accessToken;
    }

    public function getAllUser()
    {
        return User::all();
    }

    public function getUserById($userID) : ?User
    {
        return User::where('id', $userID)->first();
    }

    public function verifyAdmin($userID) : bool
    {
        return (bool) User::where('id', $userID)->where('type', 'admin')->first();
    }
}
