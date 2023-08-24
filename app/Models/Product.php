<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'is_available',
        'image',
        'seller_id',

        'created_by',
        'updated_by'
    ];
    protected $hidden = [
        'pivot'
    ];



    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
                    ->withTimestamps();
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function isAvailable()
    {
        return $this->is_available;
    }

    // protected function Image(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => (str_contains($value, 'public/')) ? 'storage/' . explode('public/', $value)[1] : $value
    //     );
    // }
}
