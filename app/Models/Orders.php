<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'code',
        'product_id',
        'quantity',
        'before',
        'after',
        'method',
        'link',
        'address',
        'status',
        'total',
        'shipping_cost'
    ];

    public const STATUS_CREATED = 0;
    public const STATUS_WAITING_SHIPPING_CONFIRM = 1;
    public const STATUS_WAITING_WEIGH = 2;
    public const STATUS_WAITING_PAYMENT = 3;
    public const STATUS_PROCESSING = 4;
    public const STATUS_READY = 5;
    public const STATUS_COMPLETED = 6;

    public function getStatusLabelAttribute(): string
    {
        return match ((int) $this->status) {
            self::STATUS_CREATED => 'Pesanan Dibuat',
            self::STATUS_WAITING_SHIPPING_CONFIRM => 'Menunggu Konfirmasi Ongkir',
            self::STATUS_WAITING_WEIGH => 'Menunggu Ditimbang',
            self::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            self::STATUS_PROCESSING => 'Pesanan Diproses',
            self::STATUS_READY => 'Pesanan Siap Diambil / Diantar',
            self::STATUS_COMPLETED => 'Pesanan Selesai',
            default => '-',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ((int) $this->status) {
            self::STATUS_CREATED => '<span class="badge bg-secondary text-white">Pesanan Dibuat</span>',
            self::STATUS_WAITING_SHIPPING_CONFIRM => '<span class="badge bg-warning text-dark">Menunggu Konfirmasi Ongkir</span>',
            self::STATUS_WAITING_WEIGH => '<span class="badge bg-warning text-dark">Menunggu Ditimbang</span>',
            self::STATUS_WAITING_PAYMENT => '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>',
            self::STATUS_PROCESSING => '<span class="badge bg-info text-white">Pesanan Diproses</span>',
            self::STATUS_READY => '<span class="badge bg-primary text-white">Pesanan Siap Diambil / Diantar</span>',
            self::STATUS_COMPLETED => '<span class="badge bg-success text-white">Pesanan Selesai</span>',
            default => '<span class="badge bg-secondary text-white">-</span>',
        };
    }

    // replace route key with code column
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }
}
