<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'note',
        'changed_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Pembayaran',
            'paid'      => 'Pembayaran Diterima',
            'shipped'   => 'Sedang Dikirim',
            'delivered' => 'Pesanan Diterima',
            'cancelled' => 'Dibatalkan',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => '#F59E0B',
            'paid'      => '#3B82F6',
            'shipped'   => '#8B5CF6',
            'delivered' => '#10B981',
            'cancelled' => '#EF4444',
            default     => '#6B7280',
        };
    }
}