<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Category;

class CategoryProductController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')
                ->only(['__invoke']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}
