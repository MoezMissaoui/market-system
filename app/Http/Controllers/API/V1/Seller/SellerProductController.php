<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\API\ApiController;
use App\Transformers\ProductTransformer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerProductController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'. ProductTransformer::class)
                ->only(['store', 'update']);
    }


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
            'image'           => 'required|image',
        ];
        $this->validate($request, $rules);

        $data = $request->all();
        $imageName =  Str::orderedUuid() . '.' . $request->image->getClientOriginalExtension();
        $data['image'] = $request->file('image')->storeAs('/public/products/images', $imageName);
        $data['created_by']      = Auth::id();
        $data['is_available']    = False;
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

        if ($request->hasFile('image')) {
            // Delete Old Image
            if(Storage::exists($product->image)){
                Storage::delete($product->image);
            }

            // set New Image
            $imageName =  Str::orderedUuid() . '.' . $request->image->getClientOriginalExtension();
            $product->image = $request->file('image')->storeAs('/public/products/images', $imageName);
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
        $product->delete();
        if(Storage::exists($product->image)){
            Storage::delete($product->image);
        }
        return $this->showOne($product); 
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
