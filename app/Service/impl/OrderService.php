<?php

namespace  App\Service\impl;

use App\Exceptions\APIException;
use App\Repository\extend\ICartRepo;
use App\Repository\extend\IOrderRepo;
use App\Service\extend\IServiceOrder;

class OrderService implements IServiceOrder
{
    protected $cartRepo, $orderRepo;

    public function __construct(ICartRepo $cartRepo, IOrderRepo $orderRepository)
    {
        $this->cartRepo = $cartRepo;
        $this->orderRepo = $orderRepository;
    }

    private function getTotalPrice($dataCart)
    {
        $totalPrice = 0;
        foreach ($dataCart as $cart) {
            $totalPrice += $cart->price * $cart->quantity;
        }

        if ($totalPrice <= 0) {
            throw new APIException(501, "Total price must be greater than zero.");
        }

        return $totalPrice;
    }

    public function getAll($req) {}

    public function findById($id) {}

    public function create($data)
    {
        $dataCart = $this->cartRepo->managerOwnCartsById($data['user_id'], $data['cart_ids']);
        $data['total_price'] = $this->getTotalPrice($dataCart);
        return $this->orderRepo->create($data);
    }

    public function update($id, $data) {}

    public function delete($id) {}
}
