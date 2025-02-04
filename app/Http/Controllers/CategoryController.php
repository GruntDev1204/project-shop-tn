<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryReq;
use App\Service\extend\IServiceCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categorySV;

    public function __construct(IServiceCategory $categorySV)
    {
        $this->categorySV = $categorySV;
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $rs = $this->categorySV->getAll();
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            return $this->returnJson("nodata", 404, "No data available");
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
            return $this->returnJson("nodata", 404, "No data available");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryReq $request)
    {
        $data = $request->all();
        $rs = $this->categorySV->create($data);
        if ($rs) {
            return $this->returnJson($rs, 201, "created!");
        } else {
            return $this->returnJson($rs, 400, "bad request!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CategoryReq $request)
    {
        $data = $request->all();
        $rs = $this->categorySV->update($id, $data);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            return $this->returnJson($rs, 404, "No data available");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rs = $this->categorySV->delete($id);
        if ($rs) {
            return $this->returnJson($rs, 200, "success!");
        } else {
            return $this->returnJson($rs, 404, "No data available");
        }
    }
}
