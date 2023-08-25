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
            'id'               => $buyer->id,
            
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
            'updatedBy'        => $buyer->updated_by
        ]; 
    }
}
