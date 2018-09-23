<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Buyer;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::_controler();
        $this->middleware('scope:read-general')->only(['show']);
        $this->middleware('can:view,buyer')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();

        $buyers = Buyer::has('transactions')->get();

        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        return  $this->showOne($buyer);
    }
}
