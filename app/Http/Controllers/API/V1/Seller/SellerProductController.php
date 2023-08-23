<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\API\ApiController;
use App\Models\Seller;

class SellerProductController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $sellers = Seller::with('products')
                        ->get();

        return $this->showAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Seller $seller
     * @return \Illuminate\Http\Response
     */

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }
}
