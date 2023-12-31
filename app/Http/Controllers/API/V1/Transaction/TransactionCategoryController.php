<?php

namespace App\Http\Controllers\API\V1\Transaction;

use App\Http\Controllers\API\ApiController;
use App\Models\Transaction;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Transaction $transaction)
    {
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }
}
