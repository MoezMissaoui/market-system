<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Category;

class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        $sellers = $category
                    ->products()
                    ->with('seller') // Eager Loading
                    ->get()
                    ->pluck('seller')
                    ->unique('id')
                    ->values();
        return $this->showAll($sellers);
    }
}
