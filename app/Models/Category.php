<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $transformer = CategoryTransformer::class;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',

        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'pivot'
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
                    ->withTimestamps();
    }


    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }


}
