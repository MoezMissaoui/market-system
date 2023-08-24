<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\API\ApiController;
use App\Models\Seller;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Seller $seller)
    {
        $categories = $seller
                    ->products()
                    ->whereHas('categories')
                    ->with('categories') // Eager Loading
                    ->get()
                    ->pluck('categories')
                    ->collapse()
                    ->unique('id')
                    ->values();
        return $this->showAll($categories);
    }
}
