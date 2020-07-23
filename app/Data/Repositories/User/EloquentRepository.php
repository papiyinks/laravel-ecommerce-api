<?php

namespace App\Data\Repositories\User;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\User
 */
class EloquentRepository implements UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
       $this->user = $user;
    }

    public function createUser($attributes)
    {

        $user = new User($attributes);

        $user->save();

        return $user;
    }
}
