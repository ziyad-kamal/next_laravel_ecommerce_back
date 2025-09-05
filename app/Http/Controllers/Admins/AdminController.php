<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Traits\{CanAccessAdminPanel, Response};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminController extends Controller
{
    use CanAccessAdminPanel,Response;

    public function __construct()
    {
        $this->canAccessAdminPanel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $keyToSort = $request->keyToSort ?? 'created_at';
        $direction = $request->direction ?? 'desc';

        $admins = Admin::selection()->orderBy($keyToSort, $direction)->paginate(5);

        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): AdminResource
    {
        $admin = Admin::create($request->validated());

        return new AdminResource($admin);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): AdminResource
    {
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin): AdminResource
    {
        $admin->update($request->validated());

        return new AdminResource($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Admin $admin): JsonResponse
    {

        if ($request->user()->id === $admin->id) {
            abort(400, "you can't delete yourself");
        }

        $admin->tokens()->delete();
        $admin->delete();

        return $this->returnSuccess('you successfully deleted admin');
    }
}
