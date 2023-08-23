<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\API\ApiController;
use App\Models\Seller;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Seller $seller)
    {
        // $categories = $buyer
        //             ->transactions()
        //             ->with('product.categories') // Eager Loading
        //             ->get()
        //             ->pluck('product.categories')
        //             ->collapse()
        //             ->unique('id')
        //             ->values();
        // return $this->showAll($categories);
    }
}
