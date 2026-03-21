<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\{AdminRequest, LoginRequest};
use App\Http\Resources\AdminResource;
use App\Interfaces\Admins\AuthRepositoryInterface;
use App\Traits\{CanAccessAdminPanel, Response};
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use CanAccessAdminPanel,Response;

    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function signup(AdminRequest $request)
    {
        $data = $this->authRepository->signupUser($request);

        return $this->returnSuccess('you successfully signup', 'data', $data);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authRepository->loginUser($request);

        return $this->returnSuccess('you successfully login', 'data', $data);
    }

    public function getProfile(Request $request)
    {
        $this->canAccessAdminPanel();
        $admin = $this->authRepository->getProfile($request->user()->id);

        return new AdminResource($admin);
    }

    public function logout(Request $request)
    {
        $this->canAccessAdminPanel();
        $this->authRepository->logoutUser($request);

        return $this->returnSuccess('you successfully logout');
    }
}
