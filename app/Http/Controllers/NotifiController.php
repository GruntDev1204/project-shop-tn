<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotifiReq;
use App\Service\extend\IServiceNotifi;

class NotifiController extends Controller
{
    private $notifiService;
    public function __construct(IServiceNotifi $notifiService)
    {
        $this->notifiService = $notifiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $this->getAuth();
        return $this->returnJson($this->notifiService->getAll("any"), 200, "success!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(NotifiReq $req)
    {
        $this->authorizeRole('CEO');
        $data = $req->all();
        $data['author_name'] = $req->is_anonymous ? null : $this->getAuth()->name;
        return $this->returnJson($this->notifiService->create($data), 201, "created success!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getById($id)
    {
        $this->getAuth();
        return $this->returnJson($this->notifiService->findById($id), 200, "success!");
    }

    public function update($id, NotifiReq $request)
    {
        $this->authorizeRole('CEO');
        $data = $request->all();
        $data['author_name'] = $request->is_anonymous ? null : $this->getAuth()->name;
        return $this->returnJson($this->notifiService->update($id, $data), 200, "success!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorizeRole('CEO');
        return $this->returnJson($this->notifiService->delete($id), 204, "success!");
    }
}
