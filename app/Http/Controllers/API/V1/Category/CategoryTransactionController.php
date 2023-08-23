<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Category;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        $transactions = $category
                    ->products()
                    ->whereHas('transactions')
                    ->with('transactions') // Eager Loading
                    ->get()
                    ->pluck('transactions')
                    ->collapse();
        return $this->showAll($transactions);
    }
}
