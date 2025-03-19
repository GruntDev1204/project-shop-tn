<?php

namespace  App\Service\impl;

use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Service\extend\IServiceProduct;

class ProductService implements IServiceProduct
{
    private $productRepo;
    public function __construct(ExtendIProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function managerAllProducts($reqParam)
    {
        $reqParam['page_size']  = $reqParam['page_size'] ?? 2;
        return $this->productRepo->managerAllProducts($reqParam);
    }

    public function getAll($reqParam)
    {
        $reqParam['page_size']  = $reqParam['page_size'] ?? 2;
        return $this->productRepo->getAll($reqParam);
    }

    public function changeStatus($id)
    {
        $this->productRepo->changeStatus($id);
    }

    public function findById($id)
    {
        return $this->productRepo->findById($id);
    }

    public function create($data)
    {
        $data['status'] = $data['status'] ?? false;
        $data['image'] = $data['image'] ?? "./public/images/electronics.jpg";
        $data['origin'] =  $data['origin'] ?? 'Hàng lậu';
        return $this->productRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->productRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepo->delete($id);
    }

    
}
