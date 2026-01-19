<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\{NotificationResource};
use App\Models\Admin;
use App\Traits\{CanAccessAdminPanel, Response};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};

use function Symfony\Component\Clock\now;

class NotificationController extends Controller
{
    use CanAccessAdminPanel,Response;

    public function __construct()
    {
        $this->canAccessAdminPanel();
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $notifications = Admin::find($request->user()->id)->notifications()->paginate(5);

        return NotificationResource::collection($notifications);
    }

    public function updateAll(Request $request): JsonResponse
    {
        Admin::find($request->user()->id)->notifications()->update(['read_at' => now()]);

        return $this->returnSuccess('you mark all notifications as read');
    }

    public function update(NotificationRequest $request): JsonResponse
    {
        Admin::find($request->user()->id)->notifications()->where('id', $request->notif_id)->update(['read_at' => now()]);

        return $this->returnSuccess('you mark notification as read');
    }
}
