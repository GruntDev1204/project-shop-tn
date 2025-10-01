<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartReq;
use App\Service\extend\IServiceCart;

class CartController extends Controller
{
    private IServiceCart $cartSV;

    public function __construct(IServiceCart $cartSV)
    {
        $this->cartSV = $cartSV;
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $user = $this->getAuth();
        if ($user  && $this->hasRole(['Admin', 'CEO'])) {
            $req = 'hello Admin';
            return $this->returnJson($this->cartSV->getAll($req), 200, "success!");
        } else {
            return $this->returnJson($this->cartSV->managerOwnCarts($user->id), 200, "success!");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CartReq $req)
    {
        $user = $this->getAuth();
        $req->merge(['user_id' => $user->id]);
        return $this->returnJson($this->cartSV->create($req->all()), 200, "success!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getById($id)
    {
        $user = $this->getAuth();
        if ($user->role === 'Admin' || $user->role === 'CEO') {
            $dataCart = $this->cartSV->findById($id);
        } else {
            $dataCart = $this->cartSV->managerOwnCart($id, $user->id);
        }

        return $this->returnJson($dataCart, 200, "success!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CartReq $request)
    {
        $user = $this->getAuth();
        $this->cartSV->managerOwnCart($id, $user->id);
        return $this->returnJson($this->cartSV->update($id, $request->all()), 200, "success!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->getAuth();
        $this->cartSV->managerOwnCart($id, $user->id);
        return $this->returnJson($this->cartSV->delete($id), 204, "success!");
    }
}
