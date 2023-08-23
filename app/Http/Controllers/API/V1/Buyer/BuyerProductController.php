<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Buyer $buyer)
    {
        $products = $buyer
                    ->transactions()
                    ->with('product') // Eager Loading
                    ->get()
                    ->pluck('product');
        return $this->showAll($products);
    }
}
