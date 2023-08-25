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
            'identifier'       => $category->id,
            
            'title'            => $category->name,
            'details'          => $category->description,

            'createdAt'        => $category->created_at,
            'updatedAt'        => $category->updated_at,
            'deletedAt'        => $category->deleted_at,

            'createdBy'        => $category->created_by,
            'updatedBy'        => $category->updated_by,

            'links'       => [
                [
                    'rel'    => 'self',
                    'href'   => route('categories.show', $category->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'self',
                    'href'   => route('categories.update', $category->id),
                    'action' => 'PUT'
                ],
                [
                    'rel'    => 'self',
                    'href'   => route('categories.destroy', $category->id),
                    'action' => 'DELETE'
                ],
                [
                    'rel'    => 'category.buyers',
                    'href'   => route('categories.buyers.index', $category->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'category.sellers',
                    'href'   => route('categories.sellers.index', $category->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'category.products',
                    'href'   => route('categories.products.index', $category->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'category.transactions',
                    'href'   => route('categories.transactions.index', $category->id),
                    'action' => 'GET'
                ],
            ]
        ]; 
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier'       => 'id',
            
            'title'            => 'name',
            'details'          => 'description',

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

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'                  => 'identifier',
            
            'name'                => 'title',
            'description'         => 'details',

            'created_at'          => 'createdAt',
            'updated_at'          => 'updatedAt',
            'deleted_at'          => 'deletedAt',

            'created_by'          => 'createdBy',
            'updated_by'          => 'updatedBy'
        ];
        return isset($attributes[$index])
                ? $attributes[$index]
                : null;
    }
}
