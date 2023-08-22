<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Models\Buyer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BuyerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $buyers = Buyer::has('transactions')->with('transactions')->get();

        return response()->json([
            'data' => $buyers
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);

        return response()->json([
            'data' => $buyer
        ], 200);
    }
}
