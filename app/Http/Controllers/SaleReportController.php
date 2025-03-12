<?php

namespace App\Http\Controllers;

use App\Models\SaleReport;
use App\Service\extend\IServiceSaleReport;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    private $saleReportSv;
    public function __construct(IServiceSaleReport $saleReportSv)
    {
        $this->saleReportSv = $saleReportSv;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $this->authorizeRole(['Admin', 'CEO']);
        return $this->saleReportSv->getAll($request);
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
    public function show(SaleReport $saleReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleReport $saleReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleReport $saleReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleReport $saleReport)
    {
        //
    }
}
