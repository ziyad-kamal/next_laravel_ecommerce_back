<?php

namespace App\Interfaces\Users;

use App\Http\Requests\{LoginRequest, UserRequest};
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function signupUser(UserRequest $request): array;

    public function loginUser(LoginRequest $request): array;

    public function logoutUser(Request $request): void;
}
