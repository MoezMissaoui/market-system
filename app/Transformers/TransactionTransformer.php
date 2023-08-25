<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier'       => $transaction->id,
            
            'quantity'         => $transaction->quantity,
            'buyer'            => $transaction->buyer_id,
            'product'          => $transaction->product_id,

            'createdAt'        => $transaction->created_at,
            'updatedAt'        => $transaction->updated_at,
            'deletedAt'        => $transaction->deleted_at,

            'createdBy'        => $transaction->created_by,
            'updatedBy'        => $transaction->updated_by
        ]; 
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier'       => 'id',
            
            'quantity'         => 'quantity',
            'buyer'            => 'buyer_id',
            'product'          => 'product_id',

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
