<?php

namespace App\Repository\impl;

use App\Models\Order;
use App\Repository\BaseRepository;
use App\Repository\extend\IOrderRepo;
use Illuminate\Support\Str;

class OrderRepo extends BaseRepository implements IOrderRepo
{
    public function getAll($req) {}

    public function findById($id) {}

    public function create($data)
    {
        return Order::create([
            'order_code' => Str::uuid(),
            'user_id' => $data['user_id'],
            'cart_ids' => $data['cart_ids'],
            'total_price' => $data['total_price'],
            'status' => $data['status'] ?? false
        ]);
    }

    public function update($id, $data) {}

    public function delete($id) {}
}
