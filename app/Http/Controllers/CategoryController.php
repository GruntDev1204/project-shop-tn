<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Requests\CategoryReq;
use App\Service\extend\IServiceCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private IServiceCategory $categorySV;

    public function __construct(IServiceCategory $categorySV)
    {
        $this->categorySV = $categorySV;
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $rs = $this->categorySV->getAll($request);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getById($id)
    {
        $rs = $this->categorySV->findById($id);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryReq $request)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $data = $request->all();
        $rs = $this->categorySV->create($data);
        if ($rs) {
            return $this->returnJson($rs, 201, "created!");
        } else {
            throw new APIException(500, "failure!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CategoryReq $request)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        $data = $request->all();
        $rs = $this->categorySV->update($id, $data);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
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
        $rs = $this->categorySV->delete($id);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            throw new APIException(500, "failure!");
        }
    }
}
