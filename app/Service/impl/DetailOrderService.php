<?php

namespace App\Service\impl;

use App\Repository\extend\IDetailOrderRepo;
use App\Service\extend\IServiceDetailOrder;

class DetailOrderService implements IServiceDetailOrder
{
    private $detailOrderRepo;
    public function __construct(IDetailOrderRepo $detailOrderRepo)
    {
        $this->detailOrderRepo = $detailOrderRepo;
    }
    public function getAll($req)
    {
        return $this->detailOrderRepo->getAll($req);
    }
    public function findById($id) {}
    public function create($data)
    {
        return $this->detailOrderRepo->create($data);
    }
    public function update($id, $data) {}
    public function delete($id) {}
}
