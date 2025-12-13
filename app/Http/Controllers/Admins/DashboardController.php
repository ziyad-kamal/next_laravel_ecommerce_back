<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Interfaces\Admins\DashboardRepositoryInterface;
use App\Traits\{CanAccessAdminPanel, Response};
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller
{
    use CanAccessAdminPanel,Response;

    public function __construct(protected DashboardRepositoryInterface $dashboardRepository)
    {
        $this->canAccessAdminPanel();
    }

    /**
     * Display a listing of the resource.
     */
    // MARK: index
    public function index(Request $request): JsonResponse
    {
        $data = $this->dashboardRepository->dashboardIndex($request);

        return response()->json($data);
    }
}
