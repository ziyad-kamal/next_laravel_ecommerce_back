<?php

namespace App\Interfaces\Admins;

use Illuminate\Http\Request;

interface DashboardRepositoryInterface
{
    public function dashboardIndex(Request $request): array;
}
