<?php

namespace App\Http\Controllers\API\V1\Transaction;

use App\Http\Controllers\API\ApiController;
use App\Models\Transaction;

class TransactionController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
