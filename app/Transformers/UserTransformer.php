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
            'identifier'       => $user->id,
            
            'firstName'        => $user->first_name,
            'lastName'         => $user->last_name,
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
            'updatedBy'        => $user->updated_by,

            'links'       => [
                [
                    'rel'    => 'self',
                    'href'   => route('users.show', $user->id),
                    'action' => 'GET'
                ],
            ]
        ]; 
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier'       => 'id',
            
            'firstName'        => 'first_name',
            'lastName'         => 'last_name',
            'age'              => 'age',
            'phone'            => 'mobile',
            'adress'           => 'adress',

            'isAdmin'          => 'is_admin',

            'email'            => 'email',
            'emailVerifiedAt'  => 'email_verified_at',

            'password'                 => 'password',
            'password_confirmation'    => 'password_confirmation',

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
            
            'first_name'         => 'firstName',
            'last_name'          => 'lastName',
            'age'                => 'age',
            'mobile'             => 'phone',
            'adress'             => 'adress',

            'is_admin'           => 'isAdmin',

            'email'              => 'email',
            'email_verified_at'  => 'emailVerifiedAt',

            'password'                 => 'password',
            'password_confirmation'    => 'password_confirmation',

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
