<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Models\Seller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $sellers = Seller::has('products')
                        ->with('products')
                        ->get();

        return response()->json([
            'data' => $sellers
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
        $seller = Seller::has('products')
                        ->with('products')
                        ->findOrFail($id);

        return response()->json([
            'data' => $seller
        ], 200);
    }
}
