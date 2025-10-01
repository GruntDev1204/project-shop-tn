<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function getAll($reqParam);
    public function findById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
