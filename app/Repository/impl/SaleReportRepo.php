<?php

namespace App\Repository\impl;

use App\Models\SaleReport;
use App\Repository\BaseRepository;
use App\Repository\extend\ISaleReportRepo;

class SaleReportRepo extends BaseRepository implements ISaleReportRepo
{
    public function getAll($reqParam)
    {
        return SaleReport::all();
    }

    public function findById($id) {}

    public function create($data)
    {
        return SaleReport::create($data);
    }

    public function update($id, $data) {}

    public function delete($id) {}

    public function changeStatus($id) {}
}
