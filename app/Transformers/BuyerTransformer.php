<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier'       => $buyer->id,
            
            'name'             => $buyer->first_name . ' ' . $buyer->last_name,
            'age'              => $buyer->age,
            'phone'            => $buyer->mobile,
            'adress'           => $buyer->adress,

            'email'            => $buyer->email,
            'emailVerifiedAt'  => $buyer->email_verified_at,

            'createdAt'        => $buyer->created_at,
            'updatedAt'        => $buyer->updated_at,
            'deletedAt'        => $buyer->deleted_at,

            'createdBy'        => $buyer->created_by,
            'updatedBy'        => $buyer->updated_by,

            'links'       => [
                [
                    'rel'    => 'self',
                    'href'   => route('buyers.show', $buyer->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'buyers.categories',
                    'href'   => route('buyers.categories.index', $buyer->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'buyers.products',
                    'href'   => route('buyers.products.index', $buyer->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'buyers.sellers',
                    'href'   => route('buyers.sellers.index', $buyer->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'buyers.transactions',
                    'href'   => route('buyers.transactions.index', $buyer->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'users',
                    'href'   => route('users.show', $buyer->id),
                    'action' => 'GET'
                ],
            ]
        ]; 
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier'       => 'id',
            
            'name'             => 'first_name',
            'age'              => 'age',
            'phone'            => 'mobile',
            'adress'           => 'adress',

            'email'            => 'email',
            'emailVerifiedAt'  => 'email_verified_at',

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
            'id'                 => 'identifier',
            
            'first_name'         => 'name',
            'age'                => 'age',
            'mobile'             => 'phone',
            'adress'             => 'adress',

            'email'              => 'email',
            'email_verified_at'  => 'emailVerifiedAt',

            'created_at'         => 'createdAt',
            'updated_at'         => 'updatedAt',
            'deleted_at'         => 'deletedAt',

            'created_by'         => 'createdBy',
            'updated_by'         => 'updatedBy'
        ];
        return isset($attributes[$index])
                ? $attributes[$index]
                : null;
    }
}
