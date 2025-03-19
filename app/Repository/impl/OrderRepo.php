<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Order;
use App\Repository\BaseRepository;
use App\Repository\extend\IOrderRepo;
use Illuminate\Support\Str;

class OrderRepo extends BaseRepository implements IOrderRepo
{
    private function findOrder($id = null, $userId = null)
    {
        $query = Order::query()
            ->when($userId !== null, fn($q) => $q->where('user_id', $userId));

        return $id
            ? $query->where('id', $id)->firstOr(fn() => throw new APIException(404, "Order not found!"))
            : $query->get()->whenEmpty(fn() => throw new APIException(404, "No orders found!"));
    }

    public function getAll($req)
    {
        return $this->findOrder();
    }

    public function findById($id)
    {
        return $this->findOrder($id, null);
    }

    public function ownOrder($userId, $id)
    {
        $order = $this->findOrder($id, $userId);
        return $order;
    }

    public function ownOrders($userId)
    {
        return $this->findOrder(null, $userId);
    }

    public function create($data)
    {
        return Order::create([
            'order_code' => Str::uuid(),
            'user_id' => $data['user_id'],
            'cart_ids' => $data['cart_ids'],
            'total_price' => $data['total_price'],
            'is_paid' => $data['is_paid'] ?? false,
            'is_canceled' => $data['is_canceled'] ?? false
        ]);
    }

    public function update($id, $data)
    {
        $order = $this->findById($id);
        if ($data['role'] === 'CEO' || $data['role'] === 'Admin') {
            $order->is_paid = !$order->is_paid;
        } else {
            $order->is_canceled = !$order->is_canceled;
        }
        $order->save();
        return $order;
    }

    public function delete($id)
    {
        $order = $this->findById($id);
        $order->delete();
        return true;
    }
}
