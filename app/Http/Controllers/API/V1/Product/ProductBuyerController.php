<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\API\ApiController;
use App\Models\Product;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        $buyers = $product
                    ->transactions()
                    ->with('buyer') // Eager Loading
                    ->get()
                    ->pluck('buyer')
                    ->unique('id')
                    ->values();
        return $this->showAll($buyers);
    }
}
