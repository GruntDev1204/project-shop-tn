<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            return response()->json(
                [
                    'status' => 200,
                    'data' => $data
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'data' => "no data available"
                ],
                404
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $result = $this->productSV->create($data);

        if ($result) {
            return response()->json(
                [
                    'status' => 201,
                    'data' => $result
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'status' => 400,
                    'data' => "fail to create resource"
                ],
                400
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getById($id)
    {
        $data = $this->productSV->findById($id);

        if (!empty($data)) {
            return response()->json(
                [
                    'status' => 200,
                    'data' => $data
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'data' => "no data available"
                ],
                404
            );
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $result = $this->productSV->update($id, $data);

        if ($result) {
            return response()->json(
                [
                    'status' => 200,
                    'data' => $result
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 400,
                    'data' => "fail to update resource"
                ],
                400
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->productSV->delete($id);

        if ($result) {
            return response()->json(
                [
                    'status' => 204,
                    'data' => $result
                ],
                204
            );
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'data' => "no data available"
                ],
                404
            );
        }
    }
}
