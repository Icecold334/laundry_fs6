<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'review'];

    /**
     * Get the order that owns the review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

