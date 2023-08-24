<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\API\ApiController;
use App\Models\Product;

class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }
}
