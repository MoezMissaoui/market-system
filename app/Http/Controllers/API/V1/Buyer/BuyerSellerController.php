<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Buyer $buyer)
    {
        $sellers = $buyer
                    ->transactions()
                    ->with('product.seller') // Eager Loading
                    ->get()
                    ->pluck('product.seller')
                    ->unique('id')
                    ->values();
        return $this->showAll($sellers);
    }
}
