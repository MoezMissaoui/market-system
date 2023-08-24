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
        $transactions = $seller
                    ->products()
                    ->whereHas('transactions')
                    ->with('transactions') // Eager Loading
                    ->get()
                    ->pluck('transactions')
                    ->collapse();
        return $this->showAll($transactions);
    }
}
