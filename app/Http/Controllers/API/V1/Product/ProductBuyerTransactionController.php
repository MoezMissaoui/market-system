<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\API\ApiController;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Product $product, User $buyer)
    {

        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request,$rules);


        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse(
                'The buyer must be diffrent from the seller.',
                Response::HTTP_CONFLICT
            );
        }
        if (!$buyer->isVerified()) {
            return $this->errorResponse(
                'The buyer must be verified user.',
                Response::HTTP_CONFLICT
            );
        }
        if (!$product->seller->isVerified()) {
            return $this->errorResponse(
                'The seller must be verified user.',
                Response::HTTP_CONFLICT
            );
        }
        if (!$product->isAvailable()) {
            return $this->errorResponse(
                'The product is not available.',
                Response::HTTP_CONFLICT
            );
        }
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse(
                'The product does not have enough units for this transaction.',
                Response::HTTP_CONFLICT
            );
        }

        return DB::transaction(function() use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity'    => $request->quantity,
                'buyer_id'    => $buyer->id,
                'product_id'  => $product->id
            ]);

            return $this->showOne($transaction, Response::HTTP_CREATED);
        });
    }
}
