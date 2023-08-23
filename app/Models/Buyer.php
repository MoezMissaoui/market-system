<?php

namespace App\Models;

use App\Scopes\BuyerScope;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{

    protected static function boot() 
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }


    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }



}
