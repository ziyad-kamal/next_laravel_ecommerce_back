<?php

namespace App\Repositories\Users;

use App\Http\Requests\{LoginRequest, UserRequest};
use App\Interfaces\Users\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash};

class AuthRepository implements AuthRepositoryInterface
{
    // MARK: store User
    public function signupUser(UserRequest $request): array
    {
        $data = $request->safe()->except('password') + ['password' => $request->password];
        $user = User::create($data);

        $tokenExpire = $request->isNotFilled('rememberMe') ? now()->addHours(4) : null;
        $token       = $user->createToken($request->email, ['*'], $tokenExpire);

        return ['token' => $token->plainTextToken, 'user' => $user];
    }

    // MARK: login
    public function loginUser(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            abort(404, 'incorrect password or email');
        }

        $tokenExpire = $request->isNotFilled('rememberMe') ? now()->addHours(4) : null;
        $token       = $user->createToken($request->email, ['*'], $tokenExpire);

        return ['token' => $token->plainTextToken, 'user' => $user];
    }

    // MARK: logout
    public function logoutUser(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
}
