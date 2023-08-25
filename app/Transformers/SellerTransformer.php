<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier'       => $seller->id,
            
            'name'             => $seller->first_name . ' ' . $seller->last_name,
            'age'              => $seller->age,
            'phone'            => $seller->mobile,
            'adress'           => $seller->adress,

            'email'            => $seller->email,
            'emailVerifiedAt'  => $seller->email_verified_at,

            'createdAt'        => $seller->created_at,
            'updatedAt'        => $seller->updated_at,
            'deletedAt'        => $seller->deleted_at,

            'createdBy'        => $seller->created_by,
            'updatedBy'        => $seller->updated_by,

            'links'       => [
                [
                    'rel'    => 'self',
                    'href'   => route('sellers.show', $seller->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'sellers.categories',
                    'href'   => route('sellers.categories.index', $seller->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'sellers.products',
                    'href'   => route('sellers.products.index', $seller->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'sellers.buyers',
                    'href'   => route('sellers.buyers.index', $seller->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'sellers.transactions',
                    'href'   => route('sellers.transactions.index', $seller->id),
                    'action' => 'GET'
                ],
                [
                    'rel'    => 'users',
                    'href'   => route('users.show', $seller->id),
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
}
