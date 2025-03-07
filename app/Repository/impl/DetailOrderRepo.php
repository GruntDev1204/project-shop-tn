<?php

namespace App\Repository\impl;

use App\Models\DetailOrder;
use App\Repository\BaseRepository;
use App\Repository\extend\IDetailOrderRepo;

class DetailOrderRepo extends BaseRepository implements IDetailOrderRepo
{
    public function getAll($req) {}

    public function findById($id) {}

    public function create($data)
    {
        return DetailOrder::create(
            [
                'order_id' => $data['order_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price']
            ]
        );
    }

    public function update($id, $data) {}

    public function delete($id) {}
}
