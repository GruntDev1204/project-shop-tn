<?php

namespace App\Repository;

class BaseRepository
{
    protected function paginateQuery($reqParam, $query)
    {
        return $query->paginate($reqParam['page_size']);
    }
}
