<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartReq;
use App\Models\Cart;
use App\Service\extend\IServiceCart;
use Illuminate\Http\Request;

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
        $req['user_id'] = $user->id;
        return $this->returnJson($this->cartSV->getAll($req), 200, "success!");
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
