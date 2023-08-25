<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'id'               => $category->id,
            
            'title'            => $category->name,
            'details'          => $category->description,

            'createdAt'        => $category->created_at,
            'updatedAt'        => $category->updated_at,
            'deletedAt'        => $category->deleted_at,

            'createdBy'        => $category->created_by,
            'updatedBy'        => $category->updated_by
        ]; 
    }
}