<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Category;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        $buyers = $category
                    ->products()
                    ->whereHas('transactions')
                    ->with('transactions.buyer') // Eager Loading
                    ->get()
                    ->pluck('transactions')
                    ->collapse()
                    ->pluck('buyer')
                    ->unique('id')
                    ->values();
        return $this->showAll($buyers);
    }
}
