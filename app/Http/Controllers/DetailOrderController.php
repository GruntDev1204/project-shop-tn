<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Service\extend\IServiceDetailOrder;
use Illuminate\Http\Request;

class DetailOrderController extends Controller
{
    private $orderSV;

    public function __construct(IServiceDetailOrder $orderService)
    {
        $this->orderSV = $orderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $this->getAuth();
        $this->validateField($request->query('order_id'), 'Id of order');
        return $this->returnJson($this->orderSV->getAll($request), 200, "success!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailOrder $detailOrder)
    {
        //
    }
}
