<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $buyers = Buyer::with('transactions')
                    ->get();

        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Buyer $buyer
     * @return \Illuminate\Http\Response
     */

    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }
}
