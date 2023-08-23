<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Buyer $buyer)
    {
        $categories = $buyer
                    ->transactions()
                    ->with('product.categories') // Eager Loading
                    ->get()
                    ->pluck('product.categories')
                    ->collapse()
                    ->unique('id')
                    ->values();
        return $this->showAll($categories);
    }
}
