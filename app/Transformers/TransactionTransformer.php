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
            'id'               => $transaction->id,
            
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
}
