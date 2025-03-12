<?php

namespace  App\Service\impl;

use App\Repository\extend\ISaleReportRepo;
use App\Service\extend\IServiceSaleReport;

class SaleReportService implements IServiceSaleReport
{
    private $saleReportRp;

    public function __construct(ISaleReportRepo $saleReportRp)
    {
        $this->saleReportRp = $saleReportRp;
    }
    public function getAll($reqParam)
    {
        return $this->saleReportRp->getAll($reqParam);
    }
    public function findById($id) {}
    public function create($data) {}
    public function update($id, $data) {}
    public function delete($id) {}
}
