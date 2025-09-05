<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CanAccessAdminPanel
{
    public function canAccessAdminPanel()
    {
        $userEmail = request()->user()->email;

        $userModel = DB::table('personal_access_tokens')
            ->where('name', $userEmail)
            ->value('tokenable_type');

        if ($userModel !== 'App\Models\Admin') {
            abort(401, "you can't access this page");
        }
    }
}
