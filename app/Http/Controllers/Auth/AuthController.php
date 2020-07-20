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
        $user = $this->user_repository->createUser();

        $token = $this->createAccessToken($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login()
    {
        $loginData = $this->user_repository->loginUser();

        if(!Auth::attempt($loginData))
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
