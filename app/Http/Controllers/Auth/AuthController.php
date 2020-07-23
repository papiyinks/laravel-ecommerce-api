<?php

namespace App\Http\Controllers\Auth;

use App\Data\Repositories\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function register()
    {
        $attributes = request()->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phoneNumber' => 'required|digits:11',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user = $this->user_repository->createUser($attributes);

        $token = $this->createAccessToken($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($attributes))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = Auth::user();

        $token = $this->createAccessToken($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function createAccessToken($user) {
        return $user->createToken('Personal Access Token')->accessToken;
    }

}
