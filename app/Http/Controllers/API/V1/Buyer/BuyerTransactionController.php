<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Buyer $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
