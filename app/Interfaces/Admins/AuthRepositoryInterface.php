<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\{AdminRequest, LoginRequest};
use App\Models\Admin;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function signupUser(AdminRequest $request): array;

    public function loginUser(LoginRequest $request): array;

    public function getProfile(int $id): Admin;

    public function logoutUser(Request $request): void;
}
