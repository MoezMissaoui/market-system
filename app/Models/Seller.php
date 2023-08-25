<?php

namespace App\Models;

use App\Scopes\SellerScope;

use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    public $transformer = SellerTransformer::class;
    protected static function boot() 
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

}
