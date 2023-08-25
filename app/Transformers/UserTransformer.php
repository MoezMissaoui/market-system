<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'id'               => $user->id,
            
            'name'             => $user->first_name . ' ' . $user->last_name,
            'age'              => $user->age,
            'phone'            => $user->mobile,
            'adress'           => $user->adress,

            'isAdmin'          => (bool)$user->is_admin,

            'email'            => $user->email,
            'emailVerifiedAt'  => $user->email_verified_at,

            'createdAt'        => $user->created_at,
            'updatedAt'        => $user->updated_at,
            'deletedAt'        => $user->deleted_at,

            'createdBy'        => $user->created_by,
            'updatedBy'        => $user->updated_by
        ]; 
    }
}
