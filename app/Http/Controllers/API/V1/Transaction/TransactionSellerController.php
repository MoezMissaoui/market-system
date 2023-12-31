<?php

namespace App\Http\Controllers\API\V1\Transaction;

use App\Http\Controllers\API\ApiController;
use App\Models\Transaction;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Transaction $transaction)
    {
        $seller = $transaction->product->seller;
        return $this->showOne($seller);
    }
}
