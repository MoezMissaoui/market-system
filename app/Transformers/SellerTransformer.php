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
            'id'               => $seller->id,
            
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
            'updatedBy'        => $seller->updated_by
        ]; 
    }
}
