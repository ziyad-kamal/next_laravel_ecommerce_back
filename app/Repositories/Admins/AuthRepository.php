<?php

namespace App\Repositories\Admins;

use App\Http\Requests\{AdminRequest, LoginRequest};
use App\Interfaces\Admins\AuthRepositoryInterface;
use App\Models\{Admin, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash};

class AuthRepository implements AuthRepositoryInterface
{
    // MARK: store User
    public function signupUser(AdminRequest $request): array
    {
        $data = $request->safe()->except('password') + ['password' => $request->password];
        $user = User::create($data);

        $token = $user->createToken($request->email, ['*'], now()->addHours(4));

        return ['token' => $token->plainTextToken, 'user' => $user];
    }

    // MARK: login
    public function loginUser(LoginRequest $request): array
    {
        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            abort(404, 'incorrect password or email');
        }

        $token = $admin->createToken($request->email, ['*'], now()->addHours(4));

        return ['token' => $token->plainTextToken, 'user' => $admin];
    }

    // MARK: logout
    public function logoutUser(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
}
