<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\API\ApiController;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }
 
 
    /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  Product $product
      * @param  User $category
      * @return \Illuminate\Http\Response
      */
 
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        $product->load('categories');
        return $this->showOne($product); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse(
                'The specified category is not a category of this product.',
                Response::HTTP_NOT_FOUND
            );
        }
        $product->categories()->detach([$category->id]);
        $product->load('categories');
        return $this->showOne($product); 
    }
}
