<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\Admins\OrderRepositoryInterface;
use App\Models\Order;
use App\Traits\{CanAccessAdminPanel, Response};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    use CanAccessAdminPanel,Response;

    public function __construct(protected OrderRepositoryInterface $orderRepository)
    {
        $this->canAccessAdminPanel();
    }

    /**
     * Display a listing of the resource.
     */
    // MARK: index
    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = $this->orderRepository->index($request);

        return orderResource::collection($orders);
    }

    // MARK: show
    public function show(Order $order): OrderResource
    {
        $orderData = $this->orderRepository->show($order);

        return new OrderResource($orderData);
    }

    // MARK: update
    public function update(OrderRequest $request, Order $order): JsonResponse
    {
        $this->orderRepository->update($order, $request);

        return $this->returnSuccess('you updated state of order successfully');
    }

    // MARK: destroy
    public function destroy(Order $order): JsonResponse
    {
        $this->orderRepository->delete($order);

        return $this->returnSuccess('you successfully deleted order');
    }
}
