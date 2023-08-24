<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\API\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
      * @param  User $seller
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, User $seller)
    {
        $rules = [
            'name'            => 'required',
            'description'     => 'required',
            'quantity'        => 'required|integer|min:1',
            'image'           => 'image',
        ];
        $this->validate($request, $rules);

        $data                    = $request->all();
        $data['created_by']      = Auth::id();
        $data['is_available']    = False;
        $data['image']           = asset('assets/img/products'. mt_rand(1, 4) . '.png');
        $data['seller_id']       = $seller?->id;

        $product = Product::create($data);

        return $this->showOne($product, Response::HTTP_CREATED);
    }
 
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  User $seller
      * @param  Product $product
      * @return \Illuminate\Http\Response
      */
 
    public function update(Request $request, User $seller, Product $product)
    {
        $rules = [
            'quantity'        => 'integer|min:1',
            'is_available'    => 'in:0,1',
            'image'           => 'image',
        ];

        $this->validate($request, $rules);
        $this->checkSeller($seller, $product);

        $product->fill(
            $request->only([
                'name',
                'description',
                'quantity',
            ])
        );

        if ($request->has('is_available')) {
            $product->is_available = (bool)$request->is_available;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse(
                    'An active product mut have at least one category',
                    Response::HTTP_CONFLICT
                );
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse(
                'You need to specify a different value to update.',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $product->save();

        return $this->showOne($product); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $seller, Product $product)
    {
        $this->checkSeller($seller, $product);
        $seller->delete();
        return $this->showOne($seller); 
    }


    protected function checkSeller(User $seller, Product $product) 
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'The specified seller is not the actual seller of the product.'
            );
        }
    }
}
