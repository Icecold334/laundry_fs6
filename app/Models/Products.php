<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'duration',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                $product->order()->forceDelete();
            } else {
                $product->order()->delete();
            }
        });
    }

    public function order(): HasMany
    {
        return $this->hasMany(Orders::class, 'product_id');
    }
}
