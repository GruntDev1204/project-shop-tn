<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReq;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productSV;

    public function __construct(ExtendIServiceProduct $productSV)
    {
        $this->productSV = $productSV;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $data = $this->productSV->getAll();

        if (!empty($data)) {
            return $this->returnJson($data, 200, "success!");
        } else {
            return $this->returnJson("nodata", 404, "No data available");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductReq $request)
    {
        $data = $request->all();
        $result = $this->productSV->create($data);
        if ($result) {
            return $this->returnJson($result, 200, "created successfully!");
        } else {
            return $this->returnJson($result, 400, "you have bad request!");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getById($id)
    {
        $data = $this->productSV->findById($id);

        if (!empty($data)) {
            return $this->returnJson($data, 200, "success!");
        } else {
            return $this->returnJson($data, 404, "data not found!");
        }
    }

    public function update($id, ProductReq $request)
    {
        $data = $request->all();
        $result = $this->productSV->update($id, $data);

        if ($result) {
            return $this->returnJson($result, 200, "success!");
        } else {
            return $this->returnJson($result, 400, "failure!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->productSV->delete($id);
        if ($result) {
            return $this->returnJson($result, 200, "success!");
        } else {
            return $this->returnJson($result, 400, "failure!");
        }
    }
}
