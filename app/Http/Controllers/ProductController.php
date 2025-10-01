<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Requests\ProductReq;
use App\Service\extend\IServiceProduct as ExtendIServiceProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ExtendIServiceProduct $productSV;

    public function __construct(ExtendIServiceProduct $productSV)
    {
        $this->productSV = $productSV;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $requestParam = $request->query();
        $user = auth()->user();

        if ($user && ($this->hasRole(['Admin', 'CEO']))) {
            $dataPage = $this->productSV->managerAllProducts($requestParam);
        } else {
            $dataPage = $this->productSV->getAll($requestParam);
        }

        $data = $this->getDataPaginate($dataPage);

        if (!empty($data)) {
            return $this->returnJson($data, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductReq $request)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $data = $request->all();

        $result = $this->productSV->create($data);
        if ($result) {
            return $this->returnJson($result, 200, "created successfully!");
        } else {
            throw new APIException(500, "failure!");
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
            throw new APIException(500, "failure!");
        }
    }

    public function update($id, ProductReq $request)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $data = $request->all();
        $result = $this->productSV->update($id, $data);

        if ($result) {
            return $this->returnJson($result, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $result = $this->productSV->delete($id);
        if ($result) {
            return $this->returnJson($result, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    public function changeStatus($id)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $result = $this->productSV->changeStatus($id);
        return $this->returnJson($result, 200, "success!");
    }
}
