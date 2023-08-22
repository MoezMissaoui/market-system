<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\API\ApiController;
use App\Models\Buyer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $buyers = Buyer::has('transactions')
                    ->with('transactions')
                    ->get();

        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $buyer = Buyer::has('transactions')
                    ->with('transactions')
                    ->findOrFail($id);

        return $this->showOne($buyer);
    }
}
