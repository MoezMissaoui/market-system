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
            'identifier'       => $product->id,
            
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

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier'       => 'id',
            
            'title'            => 'name',
            'details'          => 'description',

            'stock'            => 'quantity',
            'isAvailable'      => 'is_available',
            'picture'          => 'image',
            'seller'           => 'seller_id',

            'createdAt'        => 'created_at',
            'updatedAt'        => 'updated_at',
            'deletedAt'        => 'deleted_at',

            'createdBy'        => 'created_by',
            'updatedBy'        => 'updated_by'
        ];
        return isset($attributes[$index])
                ? $attributes[$index]
                : null;
    }
}
