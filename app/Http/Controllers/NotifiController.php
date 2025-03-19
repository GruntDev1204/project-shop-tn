<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotifiReq;
use App\Models\Notifi;
use App\Service\extend\IServiceNotifi;
use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     */
    public function show(Notifi $notifi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notifi $notifi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notifi $notifi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifi $notifi)
    {
        //
    }
}
