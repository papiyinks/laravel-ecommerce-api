<?php

namespace App\Data\Repositories\User;

use App\User;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\User
 */
class EloquentRepository implements UserRepository
{
    /**
     * @return mixed
     */
    public function createUser()
    {
        request()->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phoneNumber' => 'required|digits:11',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user = new User([
            'firstname' => request()->firstname,
            'lastname' => request()->lastname,
            'phoneNumber' => request()->phoneNumber,
            'email' => request()->email,
            'password' => bcrypt(request()->password)
        ]);

        $user->save();

        return $user;
    }

    public function loginUser()
    {
        request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        return $credentials;
    }
}
