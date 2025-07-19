<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequest, UserRequest};
use App\Interfaces\Users\AuthRepositoryInterface;
use App\Traits\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Response;

    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function signup(UserRequest $request)
    {
        $data = $this->authRepository->signupUser($request);

        return $this->returnSuccess('you successfully signup', 'data', $data);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authRepository->loginUser($request);

        return $this->returnSuccess('you successfully login', 'data', $data);
    }

    public function logout(Request $request)
    {
        $this->authRepository->logoutUser($request);

        return $this->returnSuccess('you successfully logout');
    }
}
