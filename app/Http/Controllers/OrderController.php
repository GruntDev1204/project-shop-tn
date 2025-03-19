<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\OrderReq;
use App\Models\Order;
use App\Service\extend\IServiceOrder;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(IServiceOrder $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getById($id)
    {
        $user = $this->getAuth();
        if ($this->hasRole(['Admin', 'CEO'])) {
            return $this->returnJson($this->orderService->findById($id), 200, "success!");
        }
        return $this->returnJson($this->orderService->ownOrder($user->id, $id), 200, "success!");
    }

    /**
     * Display the specified resource.
     */
    public function getAll()
    {
        $user = $this->getAuth();
        if ($this->hasRole(['Admin', 'CEO'])) {
            return $this->returnJson($this->orderService->getAll("any"), 200, "success!");
        }

        return $this->returnJson($this->orderService->ownOrders($user->id), 200, "success!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderReq $request)
    {
        $user = $this->getAuth();
        if (!$user->status) {
            throw new AuthException("Mày đéo xác thực email mà đòi mua đồ à , đấm chết bà mày giờ!");
        }
        $request->merge(['user_id' => $user->id]);
        $data = $request->all();
        return $this->returnJson($this->orderService->create($data), 201, "created successfully!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $user = $this->getAuth();
        $data['role'] = $user->role;
        return $this->returnJson($this->orderService->update($id, $data), 200, "change status successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        return $this->returnJson($this->orderService->delete($order->id), 204, "success!");
    }
}
