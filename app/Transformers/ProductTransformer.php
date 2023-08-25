<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id'               => $product->id,
            
            'title'            => $product->name,
            'details'          => $product->description,

            'stock'            => $product->quantity,
            'isAvailable'      => $product->is_available,
            'picture'          =>   (str_contains($product->image, 'public/')) 
                                    ? 'storage/' . explode('public/', $product->image)[1] 
                                    : $product->image,
            'seller'           => $product->seller_id,

            'createdAt'        => $product->created_at,
            'updatedAt'        => $product->updated_at,
            'deletedAt'        => $product->deleted_at,

            'createdBy'        => $product->created_by,
            'updatedBy'        => $product->updated_by
        ]; 
    }
}
